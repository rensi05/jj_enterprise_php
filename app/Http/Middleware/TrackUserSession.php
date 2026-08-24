<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;

class TrackUserSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userAgent = $request->userAgent();

            UserSession::where('user_id', $user->id)
                ->where('user_agent', $userAgent)
                ->where('status', 'active')
                ->whereNull('logout_at')
                ->latest()
                ->first()
                ?->update(['last_activity_at' => now()]);
        }

        return $next($request);
    }
}
