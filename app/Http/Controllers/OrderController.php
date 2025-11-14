<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrder;
use App\Models\ChequeCategories;
use App\Models\Color;
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
        if (Auth::check()) {
            $orders = Order::with(['customer', 'subcategory', 'subcategoryItem', 'chequeCategory'])
                ->where('vendor_id', Auth::user()->id)
                ->latest()
                ->get();

            foreach ($orders as $order) {
                $customerDetails = Customer::find($order->customer_id);
                $order->customerDetails = $customerDetails;
            }

            $totalPrices = [];

            foreach ($orders as $order) {
                // Try new system first (subcategory_id)
                if ($order->subcategory_id && $order->subcategory) {
                    $price = $order->price ?? 0;
                    $category = $order->subcategory->categories()->first();
                    $chequeType = $category ? $category->name : 'Unknown';
                    $chequeSubCategory = $order->subcategory->name;
                    $chequeName = $order->subcategory->name;

                    $totalPrice = $order->quantity * $price;

                    $totalPrices[$order->id] = [
                        'totalPrice' => $totalPrice,
                        'chequeSubCategory' => $chequeSubCategory,
                        'chequeType' => $chequeType,
                        'chequeName' => $chequeName,
                    ];
                }
                // Fall back to old system (cheque_category_id)
                elseif ($order->cheque_category_id) {
                    $chequeData = ChequeCategories::find($order->cheque_category_id);

                    if ($chequeData) {
                        $price = (float) $chequeData->price;

                        $manualCheque = (int) $chequeData->manual_cheque_id;
                        $laserCheque = (int) $chequeData->laser_cheque_id;
                        $personalCheque = (int) $chequeData->personal_cheque_id;

                        $chequeSubCategory = 'Unknown';
                        $chequeType = 'Unknown';

                        if ($manualCheque !== 0) {
                            $chequeType = 'Manual Cheque';
                            $chequeSubCategory = ManualCheque::where('id', $manualCheque)->pluck('categoriesName')->first() ?? 'Manual Cheque';
                        } elseif ($laserCheque !== 0) {
                            $chequeType = 'Laser Cheque';
                            $chequeSubCategory = LaserCheque::where('id', $laserCheque)->pluck('categoriesName')->first() ?? 'Laser Cheque';
                        } elseif ($personalCheque !== 0) {
                            $chequeType = 'Personal Cheque';
                            $chequeSubCategory = 'Personal Cheque';
                        }

                        $totalPrice = $order->quantity * $price;

                        $totalPrices[$order->id] = [
                            'totalPrice' => $totalPrice,
                            'chequeSubCategory' => $chequeSubCategory,
                            'chequeType' => $chequeType,
                            'chequeName' => $chequeData->chequeName ?? 'Unknown',
                        ];
                    } else {
                        $totalPrices[$order->id] = [
                            'totalPrice' => 0,
                            'chequeSubCategory' => 'Unknown',
                            'chequeType' => 'Unknown',
                            'chequeName' => 'Unknown',
                        ];
                    }
                } else {
                    $totalPrices[$order->id] = [
                        'totalPrice' => 0,
                        'chequeSubCategory' => 'Unknown',
                        'chequeType' => 'Unknown',
                        'chequeName' => 'Unknown',
                    ];
                }
            }

            return view('partials.orderHistory', compact('orders', 'totalPrices'));
        } else {
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
        $colors = Color::where('is_active', true)->orderBy('name')->get();

        // Determine the category and subcategory names
        if ($chequeList->manual_cheque_id) {
            $chequeCategoryName = 'Manual Cheques';
            $chequeSubCategoryName = ManualCheque::where('id', $chequeList->manual_cheque_id)->pluck('categoriesName')->first();
        } else {
            $chequeCategoryName = 'Laser Cheques';
            $chequeSubCategoryName = LaserCheque::where('id', $chequeList->laser_cheque_id)->pluck('categoriesName')->first();
        }

        // Pass the cheque category data to the view
        return view('partials/chequeDetailsForm', compact('chequeList', 'chequeCategoryName', 'chequeSubCategoryName', 'customers', 'colors'));
    }



    public function checkOrders($customerId, $categoryId)
    {
        $hasOrders = Order::where('customer_id', $customerId)
            ->where('cheque_category_id', $categoryId)
            ->exists();


        return response()->json(['hasOrders' => $hasOrders]);
    }


    public function reorder(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|integer|exists:orders,customer_id',
            'cheque_start_number' => 'required|integer',
            // 'cheque_end_number' => 'required|integer|gte:cheque_start_number',
            'quantity' => 'required|integer|min:50',
        ]);

        // Get the latest (or first) order for that customer
        $originalOrder = Order::where('customer_id', $validatedData['customer_id'])->latest()->first();

        if (!$originalOrder) {
            return back()->with('error', 'No previous order found for this customer.');
        }

        // Duplicate the order
        $newOrder = $originalOrder->replicate();

        // Apply the updated fields
        $newOrder->cheque_start_number = $validatedData['cheque_start_number'];
        // $newOrder->cheque_end_number = $validatedData['cheque_end_number'];
        $newOrder->quantity = $validatedData['quantity'];
        $newOrder->reorder = 'reordered';  // mark it as reorder

        $customers = Customer::findOrFail($request->customer_id);

        $newOrder->order_status = 'pending';
        $newOrder->balance_status = 'pending';

        $newOrder->save();

        // Load relationships for email
        $newOrder->load(['subcategory', 'chequeCategory']);

        $newOrder->company = $customers->company;
        $user = Auth::user();

        if ($user->role == 'vendor') {
            Mail::to($user->email)->send(new OrderPlaced($newOrder));
        }

        if ($user->role == 'admin') {
            Mail::to($user->email)->send(new AdminOrder($newOrder));
        }

        return redirect()->back()->with('success', 'Reorder placed successfully!');
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
            'voided_cheque_file' => 'nullable|file',
            'voided_cheque' => 'nullable|string',
            'institution_number' => 'nullable|string|max:20',
            'transit_number' => 'nullable|string|max:20',
            'account_number' => 'nullable|string|max:20',
            'confirm_account_number' => 'nullable|string',
            'cheque_start_number' => 'nullable|string|max:20',
            'cheque_end_number' => 'nullable|integer|min:1',
            'cart_quantity' => 'nullable|integer|min:1',
            'cheque_category_id' => 'nullable|integer',
            'subcategory_id' => 'nullable|integer',
            'subcategory_item_id' => 'nullable|integer|exists:subcategory_items,id',
            'company_logo' => 'nullable|file',
            'cheque_img' => 'nullable|string',
            'reorder' => 'nullable|string',
            'signature_line' => 'nullable|string',
            'logo_alignment' => 'nullable|string',
            'vendor_id' => 'nullable|integer',
            'quantity_option' => 'nullable|string',
        ]);

        // Handle both old (cheque_category_id) and new (subcategory_id) systems
        if ($request->has('subcategory_id') && !$request->has('cheque_category_id')) {
            $request->merge(['cheque_category_id' => $request->subcategory_id]);
        }

        // Calculate and add price for new system
        if ($request->has('subcategory_id') && $request->has('quantity')) {
            $pricing = \App\Models\Pricing::whereHas('quantityTier', function($query) use ($request) {
                $query->where('quantity', $request->quantity);
            })->where('subcategory_id', $request->subcategory_id)->first();

            if ($pricing) {
                $request->merge(['price' => $pricing->price]);
            }
        }

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
        $order->reorder = '-';


        // Save the order to the database
        $order->save();

        // Load relationships for email
        $order->load(['subcategory', 'subcategoryItem', 'chequeCategory']);

        // add company name to order
        $order->company = $customers->company;

        // dd($request->all(),$order);

        // Send email notification to the authenticated user
        $user = Auth::user();
        // Retrieve Admin Email (from Database or .env)
        // $vendorEmail = User::where('role', 'vendor')->first()->email ?? env('VENDOR_EMAIL');

        // Send Email to User
        if ($user->role == 'vendor') {
            Mail::to($user->email)->send(new OrderPlaced($order));
        }


        // $adminEmail = User::where('role', 'admin')->first()->email ?? env('ADMIN_EMAIL');
        // dd($adminEmail);
        // Send Email to User
        if ($user->role == 'admin') {
            Mail::to($user->email)->send(new AdminOrder($order));
        }

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
