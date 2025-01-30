<?php

namespace App\Http\Controllers;

use App\Models\ChequeCategories;
use App\Models\Customer;
use App\Models\LaserCheque;
use App\Models\ManualCheque;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class OrderController extends Controller
{

    public function history()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve all orders made by the logged-in user
            $orders = Order::where('vendor_id', Auth::user()->id)->latest()->get();
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
        // Get the current authenticated user's ID (assuming they are the vendor)
        $vendorId = Auth::user()->id;

        // Find the most recent order for this customer where the vendor_id matches the current user's ID
        $latestOrder = Order::where('customer_id', $customerId)
            ->where('vendor_id', $vendorId)
            ->latest()
            ->first();

        // Check if an order was found
        if (!$latestOrder) {
            return response()->json(['error' => 'No matching order found for this customer and vendor'], 404);
        }

        // Validate the request input except for quantity (it can be optional)
        $validatedData = $request->validate([
            'cheque_start_number' => 'required|integer',
            'cheque_end_number' => 'required|integer',
        ]);

        // If quantity is provided, use it; otherwise, fallback to the last order's quantity
        $quantity = $request->input('quantity', $latestOrder->quantity);

        // Create a new order by replicating the latest one and updating fields
        $reorder = $latestOrder->replicate(); // Replicate the latest order to create a new one
        $reorder->quantity = $quantity; // Use the provided or last quantity
        $reorder->cheque_start_number = $validatedData['cheque_start_number'];
        $reorder->cheque_end_number = $validatedData['cheque_end_number'];
        $reorder->reorder = '1';

        // Save the new order
        $reorder->save();

        // Return a JSON response or redirect to success page
        return response()->json(['message' => 'Reorder placed successfully!', 'order' => $reorder], 200);
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

        if ($request->hasFile('cheque_img')) {
            $file = $request->file('cheque_img');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/logos', $filename);
            $order->cheque_img = $filename;
        }

        // Set default values for order_status and balance_status
        $order->order_status = 'pending';
        $order->balance_status = 'pending';
        $order->reorder = '1';

        // Save the order to the database
        $order->save();

        // Send email notification to the authenticated user
        $user = Auth::user();
        Mail::to($user->email)->send(new OrderPlaced($order));

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
