<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'telephone' => $request->telephone,
            'company' => $request->company,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'buzzer_code' => $request->buzzer,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'state' => $request->zone_id,
            'country' => $request->zone_country_id,
            'email' => $request->email_address,
            'status' => 'pending',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));
        Mail::to($user->email)->send(new UserCreated($user));

        if ($user->role === 'vendor') {
            return redirect()->route('login')->with('success', 'Vendor account created. Please wait for approval or contact the admin.');
        }

        Auth::login($user);
        return redirect(route('dashboard'))->with('success', 'Account created successfully!');
    }

}
