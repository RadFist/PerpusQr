<?php

namespace App\Http\Controllers;


use App\Models\Loging;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authentication extends Controller
{
    public function loginPage()
    {
        $title = "Login Page";


        return  view('page.login', [
            'tite' => $title,
        ]);
    }

    public function registerPage()
    {
        $title = "Registration Page";

        return view('page.register', [
            'tite' => $title,
        ]);
    }

    //post login logic function
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    //post registration logic function
    public function registration(Request $request)
    {
        try {

            if ($request->role == "user") {
                Member::create([
                    'nama' => request()->name,
                    'email' => request()->email,
                ]);
                Loging::addMember($request->name, 'ditambahkan', 'member');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'nullable'
            ]);

            // Simpan user baru
            $user = User::create($validated);

            // Login otomatis setelah registrasi (optional)
            Auth::login($user);

            if ($request->role != "user") {

                Loging::addMember($request->name, 'ditambahkan', "admin");

                return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
            } else {
                // return redirect('/BookList')->with('success', 'Registrasi berhasil! Selamat datang.');
            }
            return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
