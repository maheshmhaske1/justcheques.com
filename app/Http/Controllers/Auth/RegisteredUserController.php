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

        // $request->validate([
        //     'firstname' => ['required', 'string', 'max:255'],
        //     'lastname' => ['required', 'string', 'max:255'],
        //     'telephone' => ['required', 'string', 'max:255'],
        //     'company' => ['required', 'string', 'max:255'],
        //     'street_address' => ['required', 'string', 'max:255'],
        //     'suburb' => ['required', 'string', 'max:255'],
        //     'buzzer_code' => ['required', 'string', 'max:255'],
        //     'city' => ['required', 'string', 'max:255'],
        //     'postcode' => ['required', 'string', 'max:255'],
        //     'state' => ['required', 'string', 'max:255'],
        //     'country' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     'role' => ['required', 'in:vendor,admin'],
        // ]);
        
        // dd($request->all());
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
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('success', "Account created successfully!");
    }
}
