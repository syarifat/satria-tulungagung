<?php

namespace App\Http\Middleware;

use App\Services\GoogleAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    protected GoogleAuthService $googleAuthService;

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$this->googleAuthService->isProfileComplete($user)) {
            // Izinkan akses ke halaman complete-profile dan logout
            if (!$request->routeIs('complete-profile', 'complete-profile.store', 'logout', 'api.*')) {
                return redirect()->route('complete-profile');
            }
        }

        return $next($request);
    }
}
