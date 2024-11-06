<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $result = $request->authenticate();

        if ($result == "We couldn't find an account with that email and password. Please try again") {
            return back()->with('error', "We couldn't find an account with that email and password. Please try again");
        } else {
            $request->session()->regenerate();

            // Check user role after authentication
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin')->with('success', "You've been successfully logged in as Admin");
            } elseif ($user->role === 'vendor') {
                return redirect()->route('dashboard')->with('success', "You've been successfully logged in as Vendor");
            }

            // Default fallback route if role is not matched
            return redirect()->intended('/')->with('success', "You've been successfully logged in");
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', "You've been successfully logout in");;
    }
}
