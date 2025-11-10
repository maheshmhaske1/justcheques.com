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

        // Check if authentication failed (any error message other than success)
        if ($result !== "You've been successfully logged in") {
            return back()->with('error', $result);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Double check user is authenticated
        if (!$user) {
            return back()->with('error', 'Authentication failed. Please try again.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin')->with('success', "You've been successfully logged in as Admin");
        }

        if ($user->role === 'vendor' && $user->status === 'approved') {
            return redirect()->route('dashboard')->with('success', "You've been successfully logged in as Vendor");
        }

        // If user is not approved vendor or role is unknown
        Auth::logout(); // recommended to force logout in such cases
        return redirect()->route('login')->with('error', "We are verifying your account. Your account will be activated soon.");
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', "You've been successfully logout in");
        ;
    }
}
