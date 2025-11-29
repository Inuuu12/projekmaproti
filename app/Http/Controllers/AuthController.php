<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = $data['login'];
        $password = $data['password'];
        $fieldOrder = [];

        if (filter_var($loginValue, FILTER_VALIDATE_EMAIL) && Schema::hasColumn('users', 'email')) {
            $fieldOrder[] = 'email';
        } else {
            if (Schema::hasColumn('users', 'username')) {
                $fieldOrder[] = 'username';
            }
            $fieldOrder[] = 'name';
        }

        foreach ($fieldOrder as $field) {
            if (Auth::attempt([$field => $loginValue, 'password' => $password])) {
                $request->session()->regenerate();

                $role = Auth::user()->role;

                if (in_array($role, ['owner', 'superadmin'])) {
                    return redirect()->intended(route('admin.dashboard'));
                }

                if ($role === 'cabang') {
                    return redirect()->intended(route('admin.kasir'));
                }

                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun ini tidak memiliki akses admin.',
                ])->onlyInput('login');
            }
        }

        return back()->withErrors([
            'login' => 'Nama/email dan password tidak cocok.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

