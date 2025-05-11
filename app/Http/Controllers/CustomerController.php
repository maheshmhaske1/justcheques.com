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
            // 'firstname' => 'required|string|max:255',
            // 'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'suburb' => 'nullable|string|max:255',
            'buzzer' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'zone_id' => 'required|string|max:255',
            // 'zone_country_id' => 'required|string|max:255',
            // 'email' => 'required|email|',
            'user_id' => 'required',
        ]);
        $customer = new Customer();
        // $customer->firstname = $request->firstname;
        // $customer->lastname = $request->lastname;
        $customer->telephone = $request->telephone;
        $customer->company = $request->company;
        $customer->street_address = $request->street_address;
        $customer->suburb = $request->suburb;
        $customer->buzzer_code = $request->buzzer; // Matches field name in DB
        $customer->city = $request->city;
        $customer->postcode = $request->postcode;
        $customer->state = $request->zone_id; // Mapping zone_id to state
        // $customer->country = $request->zone_country_id; // Mapping zone_country_id to country
        // $customer->email = $request->email;
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
