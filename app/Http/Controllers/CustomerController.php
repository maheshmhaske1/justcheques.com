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
            'company' => 'required|string|max:255',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'zone_id' => 'nullable|string|max:100',
            'zone_country_id' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);


        $customer = new Customer();
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->telephone = $request->telephone;
        $customer->company = $request->company;
        $customer->street_address = $request->street_address;
        $customer->suburb = $request->suburb;
        $customer->buzzer_code = $request->buzzer;
        $customer->city = $request->city;
        $customer->postcode = $request->postcode;
        $customer->state = $request->zone_id;
        $customer->country = $request->zone_country_id;
        $customer->email = $request->email;
        $customer->user_id = $request->user_id;
        $customer->save();


        return redirect()->route('customer.history')->with('success', 'Customer added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('partials/customer/editCustomerForm', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {

        $validated = $request->validate([
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer_code' => 'nullable|string|max:255',  // Changed from 'buzzer'
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'state' => 'nullable|string|max:2',         // Changed from 'zone_id'
            'country' => 'nullable|string|max:255',     // Changed from 'zone_country_id'
        ]);

        $customer->update($validated);

        return redirect()->route('customer.history')
            ->with('success', 'Customer updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.history')
            ->with('success', 'Customer deleted successfully.');
    }
}
