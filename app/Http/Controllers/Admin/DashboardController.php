<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $totalUsers=User::all()->count();
        $users=User::all();
        $totalOrder=Order::all()->count();
        $totalCustomer = Customer::all()->count();
        $orders = Order::all();
        $totalVendor=User::where('role', 'vendor')->count();

        return view('admin/partials/dashboard/dashboard',compact('totalUsers', 'totalOrder', 'totalVendor', 'totalCustomer','users','orders'));
    }
}
