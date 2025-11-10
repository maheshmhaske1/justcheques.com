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
use App\Mail\NotifyAdminOfNewVendorMail;

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

        // Send email verification notification to user
        Mail::to($user->email)->send(new UserCreated($user));

        // Notify admin about new user registration
        Mail::to('order@justcheques.ca')->send(new NotifyAdminOfNewVendorMail($user));

        // Do not log the user in automatically - they need to verify email first
        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account before logging in.');
    }

}
