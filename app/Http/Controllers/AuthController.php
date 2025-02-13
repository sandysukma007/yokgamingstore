<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        if (!$user->is_verified) {
            // Generate verification code
            $verificationCode = rand(100000, 999999);
            $user->verification_code = $verificationCode;
            $user->save();

            // Send email
            Mail::raw("Your verification code is: $verificationCode", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification');
            });

            return back()->withErrors(['email' => 'Please verify your email. A verification code has been sent.']);
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors(['password' => 'Invalid credentials.']);
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate verification code
        $verificationCode = rand(100000, 999999);

        // Simpan user dengan status belum terverifikasi
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => false,
            'verification_code' => $verificationCode,
        ]);

        // Kirim email verifikasi
        Mail::raw("Your verification code is: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Email Verification');
        });

        return redirect()->route('verify.form')->with('email', $user->email);
    }

    public function showVerificationForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }

        // Update user sebagai terverifikasi
        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        return redirect('/login')->with('success', 'Email verified! You can now log in.');
    }
}
