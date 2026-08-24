<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;

class SessionManagementController extends Controller
{
    public function activeSessions()
    {
        $user = Auth::user();
        $sessions = $user->activeSessions()->get();

        return view('sessions.active', compact('sessions'));
    }

    public function logoutSession($sessionId)
    {
        $user = Auth::user();
        $session = UserSession::where('id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Session not found');
        }

        $session->markLogout();

        return redirect()->back()->with('success', 'Session logged out successfully');
    }

    public function logoutAllOtherSessions()
    {
        $user = Auth::user();
        $currentUserAgent = request()->userAgent();

        UserSession::where('user_id', $user->id)
            ->where('user_agent', '!=', $currentUserAgent)
            ->where('status', 'active')
            ->whereNull('logout_at')
            ->update([
                'status' => 'inactive',
                'logout_at' => now(),
            ]);

        return redirect()->back()->with('success', 'All other sessions logged out successfully');
    }
}
