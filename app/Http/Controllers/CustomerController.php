<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('partials/customer/customerForm');
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
       $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'zone_id' => 'required|string|max:255',
            'zone_country_id' => 'required|string|max:255',
            'email' => 'required|email|',
            'user_id' => 'required',
        ]);
        $customer = new Customer();
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->telephone = $request->telephone;
        $customer->company = $request->company;
        $customer->street_address = $request->street_address;
        $customer->suburb = $request->suburb;
        $customer->buzzer_code = $request->buzzer; // Matches field name in DB
        $customer->city = $request->city;
        $customer->postcode = $request->postcode;
        $customer->state = $request->zone_id; // Mapping zone_id to state
        $customer->country = $request->zone_country_id; // Mapping zone_country_id to country
        $customer->email = $request->email;
        $customer->user_id = $request->user_id;

        $customer->save();

        return redirect()->route('customer')->with('success', 'Customer added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
