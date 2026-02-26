<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\VideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('dashboard');
            }

            return redirect()->route('catalog');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        return view('admin.dashboard', [
            'totalUsers'      => User::count(),
            'totalVideos'     => Video::count(),
            'totalCategories' => VideoCategory::count(),
            'pendingRequests' => VideoRequest::where('status', 'pending')->count(),
            'recentRequests'  => VideoRequest::with(['user', 'video'])->latest()->take(5)->get(),
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
