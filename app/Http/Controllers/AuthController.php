<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
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

    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->code)
                    ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        return redirect()->route('login.form')->with('message', 'Email verified. Please log in.');
    }
}
