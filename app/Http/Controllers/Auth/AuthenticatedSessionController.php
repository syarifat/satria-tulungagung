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
        $request->authenticate();

        $request->session()->regenerate();

        // --- LOGIKA REDIRECT BERDASARKAN ROLE ---
        $role = $request->user()->role;

        switch ($role) {
            case 'admin_pc':
                return redirect()->intended(route('admin_pc.dashboard', absolute: false));
            
            case 'admin_pac':
                return redirect()->intended(route('admin_pac.dashboard', absolute: false));
            
            case 'admin_pr':
                return redirect()->intended(route('admin_pr.dashboard', absolute: false));
            
            case 'anggota':
                return redirect()->intended(route('anggota.dashboard', absolute: false));
                
            default:
                // Jika tidak punya role khusus, lempar ke dashboard umum atau home
                return redirect()->intended(route('dashboard', absolute: false));
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

        return redirect('/');
    }
}
