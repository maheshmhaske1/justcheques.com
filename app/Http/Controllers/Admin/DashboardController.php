<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChequeCategories;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;

class DashboardController extends Controller
{
    public function index()
    {

        $totalUsers = User::count();
        $totalOrder = Order::count();
        $totalCustomer = Customer::count();
        $totalVendor = User::where('role', 'vendor')->count();

        // Paginate users and orders
        $users = User::paginate(10); // Adjust the number of items per page as needed
        $orders = Order::paginate(10);

        return view('admin/partials/dashboard/dashboard', compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer', 'users', 'orders'));
    }

    public function orders()
    {
        $totalOrder = Order::count();

        // Paginate and orders
        $orders = Order::paginate(10);

        return view('admin/partials/dashboard/orders/index', compact('totalOrder', 'orders'));
    }



    public function userStore(Request $request)
    {
        // Validate and store user data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'state' => 'required|string|max:50',
            'country' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'email_verified_at' => 'nullable|string|',
            'password' => 'required|max:16',
            'role' => 'required|in:vendor,admin',
        ]);
        // Create user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'telephone' => $request->telephone,
            'company' => $request->company,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'buzzer_code' => $request->buzzer_code,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'state' => $request->state,
            'country' => $request->country,
            'email' => $request->email,
            'email_verified_at' => $request->email_verified_at,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function userEdit($id)
    {
        $userData = User::findOrFail($id);

        $totalUsers = User::count();
        $totalOrder = Order::count();
        $totalCustomer = Customer::count();
        $totalVendor = User::where('role', 'vendor')->count();

        // Paginate users and orders
        $users = User::paginate(10); // Adjust the number of items per page as needed
        $orders = Order::paginate(10);

        return view('admin/partials/dashboard/dashboard', compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer', 'users', 'orders', 'userData'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'state' => 'required|string|max:50',
            'country' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|max:16',
            'role' => 'required|in:vendor,admin',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin')->with('success', 'User updated successfully.');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    //Oders

    public function orderStore(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|string',
            'quantity' => 'required|integer',
            'color' => 'nullable|string',
            'company_info' => 'nullable|string',
            'voided_cheque' => 'nullable|string',
            'institution_number' => 'nullable|string',
            'transit_number' => 'nullable|string',
            'account_number' => 'nullable|string',
            'confirm_account_number' => 'nullable|string',
            'cheque_start_number' => 'nullable|string',
            'cart_quantity' => 'required|integer',
            'cheque_category_id' => 'nullable|string',
            'voided_cheque_file' => 'nullable|file',
            'company_logo' => 'nullable|file',
            'vendor_id' => 'required|string',
            'cheque_img' => 'nullable|file',
            'order_status' => 'nullable|string',
            'balance_status' => 'nullable|string',
            'reorder' => 'nullable|string',
        ]);
        $order = new Order($request->all());

        if ($request->hasFile('voided_cheque_file')) {
            $file = $request->file('voided_cheque_file');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->voided_cheque_file = $filename;
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->company_logo = $filename;
        }

        if ($request->hasFile('cheque_img')) {
            $file = $request->file('cheque_img');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->cheque_img = $filename;
        }

        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Order created successfully!');
    }

    public function orderEdit($id)
    {
        $orderData = Order::findOrFail($id);

        $totalUsers = User::count();
        $totalOrder = Order::count();
        $totalCustomer = Customer::count();
        $totalVendor = User::where('role', 'vendor')->count();

        // Paginate users and orders
        $users = User::paginate(10); // Adjust the number of items per page as needed
        $orders = Order::paginate(10);

        return view('admin/partials/dashboard/orders/index', compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer', 'users', 'orders', 'orderData'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|string',
            'quantity' => 'required|integer',
            'color' => 'nullable|string',
            'company_info' => 'nullable|string',
            'voided_cheque' => 'nullable|string',
            'institution_number' => 'nullable|string',
            'transit_number' => 'nullable|string',
            'account_number' => 'nullable|string',
            'confirm_account_number' => 'nullable|string',
            'cheque_start_number' => 'nullable|string',
            'cart_quantity' => 'required|integer',
            'cheque_category_id' => 'nullable|string',
            'voided_cheque_file' => 'nullable|file',
            'company_logo' => 'nullable|file',
            'vendor_id' => 'required|string',
            'cheque_img' => 'nullable|file',
            'order_status' => 'nullable|string',
            'balance_status' => 'nullable|string',
            'reorder' => 'nullable|string',
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);
        $order->fill($request->all()); // Update fields with the request data

        // Handle file uploads
        if ($request->hasFile('voided_cheque_file')) {
            // Delete old file if exists
            if ($order->voided_cheque_file) {
                File::delete(public_path('assets/front/img/' . $order->voided_cheque_file));
            }

            $file = $request->file('voided_cheque_file');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->voided_cheque_file = $filename;
        }

        if ($request->hasFile('company_logo')) {
            // Delete old file if exists
            if ($order->company_logo) {
                File::delete(public_path('assets/front/img/' . $order->company_logo));
            }

            $file = $request->file('company_logo');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->company_logo = $filename;
        }

        if ($request->hasFile('cheque_img')) {
            // Delete old file if exists
            if ($order->cheque_img) {
                File::delete(public_path('assets/front/img/' . $order->cheque_img));
            }

            $file = $request->file('cheque_img');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $order->cheque_img = $filename;
        }

        $order->update();

        return redirect()->route('admin.orders')->with('success', 'Order updated successfully!');
    }


    public function orderDestroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully');
    }

    //customer
    public function customerIndex()
    {
        $customers = Customer::paginate(10);
        return view('admin/partials/customers/index', compact('customers'));
    }

    public function customerStore(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'user_id' => 'required|exists:users,id',
        ]);
        Customer::create($validated);

        return redirect()->route('admin.customer')->with('success', 'Customer created successfully.');
    }

    public function customerEdit($id)
    {
        $customerData = Customer::findOrFail($id);
        $customers = Customer::paginate(10);
        return view('admin/partials/customers/index', compact('customerData', 'customers'));
    }

    public function customerUpdate(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email',
            'user_id' => 'required|exists:users,id',
        ]);
        $customer->update($request->all());

        return redirect()->route('admin.customer')->with('success', 'Customer Updated successfully.');
    }

    public function customerDestroy($id)
    {
        $order = Customer::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.customer')->with('success', 'Customer deleted successfully');
    }



    //chequeCategories

    public function chequeCategoriesIndex()
    {
        $chequeCategories = ChequeCategories::paginate(10);
        return view('admin.partials.cheques_categories.index', compact('chequeCategories'));
    }


    public function chequeCategoriesStore(Request $request)
    {
        $request->validate([
            'manual_cheque_id' => 'nullable|string',
            'laser_cheque_id' => 'nullable|string',
            'personal_cheque_id' => 'nullable|string',
            'chequeName' => 'required|string',
            'price' => 'required|numeric',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $data['img'] = $filename;
        }

        ChequeCategories::create($data);
        return redirect()->route('admin.cheque_categories')->with('success', 'Cheque Category added successfully.');
    }

    public function chequeCategoriesEdit($id)
    {
        $chequeCategoryData = ChequeCategories::findOrFail($id);
        $chequeCategories = ChequeCategories::paginate(10);
        return view('admin.partials.cheques_categories.index', compact('chequeCategoryData', 'chequeCategories'));
    }

    public function chequeCategoriesUpdate(Request $request, $id)
    {
        $customer = ChequeCategories::findOrFail($id);

        $request->validate([
            'manual_cheque_id' => 'nullable|string',
            'laser_cheque_id' => 'nullable|string',
            'personal_cheque_id' => 'nullable|string',
            'chequeName' => 'required|string',
            'price' => 'required|numeric',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $data['img'] = $filename;
        }

        $customer->update($data);

        return redirect()->route('admin.cheque_categories')->with('success', 'Cheque Category Updated successfully.');
    }

    public function chequeCategoriesDestroy($id)
    {
        $chequeCategories = ChequeCategories::findOrFail($id);
        $chequeCategories->delete();

        return redirect()->route('admin.cheque_categories')->with('success', 'Cheque Category deleted successfully.');
    }


    public function accountDetails()
    {
        $users = Auth::user();
        $logoName = substr($users->firstname, 0, 1) . substr($users->lastname, 0, 1);

        return view('admin.login.profile', compact('users', 'logoName'));
    }
}
