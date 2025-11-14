<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\Category;
use App\Models\ChequeCategories;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Validator;
use App\Mail\VendorAccountCreatedMail;
use App\Mail\NotifyAdminOfNewVendorMail;
use App\Mail\UserStatusUpdated;


class DashboardController extends Controller
{
    public function index()
    {

        $totalUsers = User::count();
        $totalOrder = Order::count();
        $totalCustomer = Customer::count();
        $totalVendor = User::where('role', 'vendor')->count();

        $totalPending = Order::where('order_status', 'pending')->count();
        $totalCompleted = Order::where('order_status', 'completed')->count();
        $totalProcessing = Order::where('order_status', 'processing')->count();

        // Paginate users and orders
        $users = User::paginate(10); // Adjust the number of items per page as needed
        $orders = Order::paginate(10);

        return view('admin/partials/dashboard/dashboard', compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer', 'users', 'orders', 'totalPending', 'totalCompleted', 'totalProcessing'));
    }

    public function orders()
    {
        $totalOrder = Order::count();

        // Paginate and orders with relationships
        $orders = Order::with(['subcategory', 'subcategoryItem'])->paginate(10);

        // dd($orders);
        return view('admin/partials/dashboard/orders/index', compact('totalOrder', 'orders'));
    }

    public function users()
    {
        $totalUsers = User::count();

        // Paginate and orders - sorted by ID descending (newest first)
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('admin/partials/dashboard/user/index', compact('totalUsers', 'users'));
    }



    public function userStore(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'status' => 'nullable|in:pending,approved',
            'email_verified_at' => 'nullable|same:email',
            'password' => 'required|string',
            'role' => 'required|string|in:vendor,admin',
        ], [
            'email.unique' => 'The email address is already registered.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'The email address is already registered.!');
        }

        // Create a new user
        $userData = new User();
        $userData->firstname = $request->input('firstname');
        $userData->lastname = $request->input('lastname');
        $userData->telephone = $request->input('telephone');
        $userData->company = $request->input('company');
        $userData->street_address = $request->input('street_address');
        $userData->suburb = $request->input('suburb');
        $userData->buzzer_code = $request->input('buzzer_code');
        $userData->city = $request->input('city');
        $userData->postcode = $request->input('postcode');
        $userData->state = $request->input('state');
        $userData->country = $request->input('country');
        $userData->email = $request->input('email');
        $userData->status = 'pending';
        $userData->role = $request->input('role');
        $userData->password = Hash::make($request->input('password'));
        $userData->save();

        if ($userData->role === 'vendor') {
            // Send email to vendor
            Mail::to($userData->email)->send(new VendorAccountCreatedMail($userData));

            $adminUser = User::where('role', 'admin')->first();

            if ($adminUser) {
                Mail::to($adminUser->email)->send(new NotifyAdminOfNewVendorMail($userData));
            }
        }

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
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

        return view('admin/partials/dashboard/user/index', compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer', 'users', 'orders', 'userData'));
    }

    public function userUpdate(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email',
            'status' => 'nullable|in:pending,approved',
            'email_verified_at' => 'nullable|same:email',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:vendor,admin',
            'notify_user' => 'nullable|boolean',
        ]);

        // Find and update user
        $userData = User::findOrFail($id);

        // Track if status changed
        $statusChanged = $userData->status !== $request->input('status');
        $oldStatus = $userData->status;

        $userData->firstname = $request->input('firstname');
        $userData->lastname = $request->input('lastname');
        $userData->telephone = $request->input('telephone');
        $userData->company = $request->input('company');
        $userData->street_address = $request->input('street_address');
        $userData->suburb = $request->input('suburb');
        $userData->buzzer_code = $request->input('buzzer_code');
        $userData->city = $request->input('city');
        $userData->postcode = $request->input('postcode');
        $userData->state = $request->input('state');
        $userData->country = $request->input('country');
        $userData->email = $request->input('email');
        $userData->status = $request->input('status');
        $userData->role = $request->input('role');

        // Only update password if provided and not empty
        if ($request->filled('password') && trim($request->input('password')) !== '') {
            $userData->password = $request->input('password'); // Will be auto-hashed by the model
        }

        $userData->update();

        // Send email notification if checkbox was checked and status changed
        if ($request->has('notify_user') && $request->input('notify_user') == '1' && $statusChanged) {
            try {
                Mail::to($userData->email)->send(new UserStatusUpdated($userData, $userData->status));
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
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
        $validated = $request->validate([
            'customer_id' => 'required|',
            'quantity' => 'required|integer',
            'color' => 'nullable|string',
            'company_info' => 'nullable|string',
            'voided_cheque' => 'nullable',
            'institution_number' => 'nullable|string',
            'transit_number' => 'nullable|string',
            'account_number' => 'nullable|string',
            'confirm_account_number' => 'nullable|string|same:account_number',
            'cheque_start_number' => 'nullable|string',
            'cheque_end_number' => 'nullable|string',
            'cart_quantity' => 'required|integer|min:1',
            'cheque_category_id' => 'required',
            'vendor_id' => 'required',
            'order_status' => 'nullable|string',
            'balance_status' => 'nullable|string',
            'reorder' => 'nullable|string',
            'voided_cheque_file' => 'nullable',
            'company_logo' => 'nullable',
            'cheque_img' => 'nullable',
        ]);

        $order = new Order($request->except(['voided_cheque_file', 'company_logo', 'cheque_img']));

        // Handle file uploads - store hashed names only
        if ($request->hasFile('voided_cheque_file')) {
            $file = $request->file('voided_cheque_file');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename); // Store in storage
            $order->voided_cheque_file = $filename; // Save only filename
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename);
            $order->company_logo = $filename;
        }

        if ($request->hasFile('cheque_img')) {
            $file = $request->file('cheque_img');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename);
            $order->cheque_img = $filename;
        }


        // Set default values for order_status and balance_status
        $order->order_status = 'pending';
        $order->balance_status = 'pending';
        $order->reorder = '1';

        // Save the order to the database
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
        $validated = $request->validate([
            'customer_id' => 'required|',
            'quantity' => 'required|integer',
            'color' => 'nullable|string',
            'company_info' => 'nullable|string',
            'voided_cheque' => 'nullable',
            'institution_number' => 'nullable|string',
            'transit_number' => 'nullable|string',
            'account_number' => 'nullable|string',
            'confirm_account_number' => 'nullable|string|same:account_number',
            'cheque_start_number' => 'nullable|string',
            'cheque_end_number' => 'nullable|string',
            'cart_quantity' => 'required|integer|min:1',
            'cheque_category_id' => 'required',
            'vendor_id' => 'required',
            'order_status' => 'nullable|string',
            'balance_status' => 'nullable|string',
            'reorder' => 'nullable|string',
            'voided_cheque_file' => 'nullable',
            'company_logo' => 'nullable',
            'cheque_img' => 'nullable',
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);
        $customers = Customer::findOrFail($request->customer_id);

        if ($order->order_status !== $request->order_status) {
            try {
                Mail::to($customers->email)->send(new OrderPlaced($order));
            } catch (\Exception $e) {
                \Log::error('Error sending order update email: ' . $e->getMessage());
            }
        }
        $order->fill($request->all()); // Update fields with the request data

        // Handle file uploads - store hashed names only
        if ($request->hasFile('voided_cheque_file')) {
            $file = $request->file('voided_cheque_file');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename); // Store in storage
            $order->voided_cheque_file = $filename; // Save only filename
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename);
            $order->company_logo = $filename;
        }

        // dd($customers);
        if ($request->hasFile('cheque_img')) {
            $file = $request->file('cheque_img');
            $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            Storage::makeDirectory('public/logos');
            $file->storeAs('public/logos', $filename);
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
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'user_id' => 'required|',
        ], [
            'email.unique' => 'The email address is already registered.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'The email address is already registered.!');
        }
        // Create a new customer
        $customer = Customer::create($request->all());

        return redirect()->route('admin.customer')->with('success', 'Customer added successfully.');
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

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email',
            'user_id' => 'required|',
        ]);
        // Create a new customer
        $customer->update($request->all());

        return redirect()->route('admin.customer')->with('success', 'Customer updated successfully.');
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

    // Colors CRUD
    public function colorsIndex()
    {
        $colors = Color::orderBy('id', 'desc')->paginate(10);
        return view('admin.partials.dashboard.colors.index', compact('colors'));
    }

    public function colorsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $data['image'] = $filename;
        }

        Color::create($data);

        return redirect()->route('admin.colors')->with('success', 'Color created successfully.');
    }

    public function colorsEdit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.partials.dashboard.colors.edit', compact('color'));
    }

    public function colorsUpdate(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($color->image && File::exists(public_path('assets/front/img/' . $color->image))) {
                File::delete(public_path('assets/front/img/' . $color->image));
            }

            $file = $request->file('image');
            $hash = md5(uniqid($file->getClientOriginalName(), true));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/img'), $filename);
            $data['image'] = $filename;
        }

        $color->update($data);

        return redirect()->route('admin.colors')->with('success', 'Color updated successfully.');
    }

    public function colorsDestroy($id)
    {
        $color = Color::findOrFail($id);

        // Delete image file if exists
        if ($color->image && File::exists(public_path('assets/front/img/' . $color->image))) {
            File::delete(public_path('assets/front/img/' . $color->image));
        }

        $color->delete();

        return redirect()->route('admin.colors')->with('success', 'Color deleted successfully.');
    }

    // Categories CRUD
    public function categoriesIndex()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.partials.dashboard.categories.index', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Category::create($data);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function categoriesEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.partials.dashboard.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $category->update($data);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function categoriesDestroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
