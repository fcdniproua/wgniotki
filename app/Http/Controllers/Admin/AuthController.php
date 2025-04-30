<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Синхронний запит до БД для дебагу
        \Log::info('Attempting login for: ' . $credentials['email']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            \Log::info('Session ID after login: ' . session()->getId());

            return response()->json([
                'message' => 'Login successful',
                'session_id' => session()->getId()
            ]);
        }

        \Log::warning('Login failed for: ' . $credentials['email']);
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function checkAuth()
    {
        return response()->json([
            'authenticated' => auth('admin')->check(),
        ]);
    }

    public function getUser()
    {
        return response()->json([
            'name' => auth('admin')->user()->name,
        ]);
    }
}