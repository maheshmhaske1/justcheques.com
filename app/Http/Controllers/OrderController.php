<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrder;
use App\Models\ChequeCategories;
use App\Models\Customer;
use App\Models\LaserCheque;
use App\Models\ManualCheque;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Mail\Reorder;
use App\Models\User;

class OrderController extends Controller
{

    public function history()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve all orders made by the logged-in user
            $orders = Order::where('vendor_id', Auth::user()->id)->latest()->get();

            foreach ($orders as $order) {
                // Retrieve customer details for each order
                $customerDetails = Customer::find($order->customer_id);
    
                // Add customer details to the order object
                $order->customerDetails = $customerDetails;
            }
            // Initialize an empty array to store total prices
            $totalPrices = [];

            // Loop through each order and calculate the total price
                foreach ($orders as $order) {
                    // Retrieve the cheque category data
                    $chequeData = ChequeCategories::find($order->cheque_category_id);


                    if ($chequeData) {
                        // Retrieve the price from the cheque category
                        $price = $chequeData->price;

                        // Determine the sub-category name based on the type of cheque
                        if ($chequeData->manual_cheque_id != 0) {
                            $chequeSubCategory = ManualCheque::where('id', $chequeData->manual_cheque_id)->pluck('categoriesName')->first();
                        } elseif ($chequeData->laser_cheque_id != 0) {
                            $chequeSubCategory = LaserCheque::where('id', $chequeData->laser_cheque_id)->pluck('categoriesName')->first();
                        } else {
                            $chequeSubCategory = 'Unknown'; // Handle case where no sub-category is found
                        }

                        // Calculate total price by multiplying quantity by price
                        $totalPrice = $order->quantity * $price;

                        // Store the total price with the order ID as the key
                        $totalPrices[$order->id] = $totalPrice;
                    } else {
                        // Handle case where cheque category is not found
                        $totalPrices[$order->id] = 0;
                    }
                }
            if ($orders->isNotEmpty()) {
                // Pass orders and total prices to the view
                return view('partials.orderHistory', compact('orders', 'totalPrices', 'chequeData', 'chequeSubCategory'));
            }else{
                return view('partials.orderHistory',compact('orders',));
            }
        } else {
            // Redirect to the login page if the user is not authenticated
            return redirect()->route('login');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // Retrieve the cheque category by id
        $chequeList = ChequeCategories::findOrFail($id);
        $customers = Customer::all();

        // Determine the category and subcategory names
        if ($chequeList->manual_cheque_id) {
            $chequeCategoryName = 'Manual Cheques';
            $chequeSubCategoryName = ManualCheque::where('id', $chequeList->manual_cheque_id)->pluck('categoriesName')->first();
        } else {
            $chequeCategoryName = 'Laser Cheques';
            $chequeSubCategoryName = LaserCheque::where('id', $chequeList->laser_cheque_id)->pluck('categoriesName')->first();
        }

        // Pass the cheque category data to the view
        return view('partials/chequeDetailsForm', compact('chequeList', 'chequeCategoryName', 'chequeSubCategoryName', 'customers'));
    }



    public function checkOrders($customerId)
    {
        $hasOrders = Order::where('customer_id', $customerId)->exists();

        return response()->json(['hasOrders' => $hasOrders]);
    }


    public function reorder(Request $request, $customerId)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'cheque_start_number' => 'required|integer',
                'cheque_end_number' => 'required|integer|gte:cheque_start_number',
                'quantity' => 'required|integer|min:50'
            ]);

            // Get the current authenticated user
            $vendorId = Auth::id();

            // Find the most recent order for this customer and vendor
            $latestOrder = Order::where('customer_id', $customerId)
                ->where('vendor_id', $vendorId)
                ->latest()
                ->firstOrFail();

            // Create a new order by replicating the latest one
            $reorder = $latestOrder->replicate();
            $reorder->fill([
                'quantity' => $validatedData['quantity'],
                'cheque_start_number' => $validatedData['cheque_start_number'],
                'cheque_end_number' => $validatedData['cheque_end_number'],
                'reorder' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $reorder->save();

            // Send email notification
            $customer = Customer::findOrFail($customerId);
            Mail::to($customer->email)->send(new Reorder($reorder));

            return response()->json([
                'success' => true,
                'message' => 'Reorder placed successfully!',
                'order' => $reorder
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No previous order found for this customer'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process reorder: ' . $e->getMessage()
            ], 500);
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'customer_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|max:255',
            'company_info' => 'nullable|string|max:1000',
            'voided_cheque_file' => 'nullable',
            'institution_number' => 'nullable|string|max:20',
            'transit_number' => 'nullable|string|max:20',
            'account_number' => 'nullable|string|max:20',
            'confirm_account_number' => 'nullable|string|same:account_number',
            'cheque_start_number' => 'nullable|integer|min:1',
            'cheque_end_number' => 'nullable|integer|min:1',
            'cart_quantity' => 'required|integer|min:1',
            'cheque_category_id' => 'required|integer',
            'company_logo' => 'nullable',
            'cheque_img' => 'nullable',
            'reorder' => 'nullable'
        ]);
        // Create a new Order object
        $order = new Order($request->except(['voided_cheque_file', 'company_logo', 'cheque_img']));
        // Handle file uploads - store hashed names only
        if ($request->hasFile('voided_cheque_file')) {
            $file = $request->file('voided_cheque_file');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/logos', $filename); // Store in storage
            $order->voided_cheque_file = $filename; // Save only filename
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/logos', $filename);
            $order->company_logo = $filename;
        }

        if ($request->cheque_img) {
        
            $order->cheque_img = $request->cheque_img;
        }


        $order->chequeCategory; 
        // dd( $order);
        $customers = Customer::findOrFail($request->customer_id);

        // Set default values for order_status and balance_status
        $order->order_status = 'pending';
        $order->balance_status = 'pending';
        $order->reorder = '1';


        // Save the order to the database
        $order->save();

        // dd($request->all(),$order);

        // Send email notification to the authenticated user
        $user = Auth::user();
        // Retrieve Admin Email (from Database or .env)
        // $vendorEmail = User::where('role', 'vendor')->first()->email ?? env('VENDOR_EMAIL');

        // Send Email to User
       
        Mail::to($customers->email)->send(new OrderPlaced($order));


        // $adminEmail = User::where('role', 'admin')->first()->email ?? env('ADMIN_EMAIL');
        // dd($adminEmail);
        // Send Email to User
        Mail::to($user->email)->send(new AdminOrder($order));

        // Send Email to Admin
        // if ($adminEmail) {
        //     Mail::to($adminEmail)->send(new AdminOrder($order));
        // }

        // Redirect to the success view
        return view('layouts/success');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
