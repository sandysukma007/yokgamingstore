<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    
    
    
    

    
    
    

    
    
    

    
    
    
    
    

    
    
    
    
    

    
    

    
    
    

    
    

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        return back()->withErrors(['email' => 'User not found.']);
    }

    if (!Hash::check($request->password, $customer->password)) {
        return back()->withErrors(['password' => 'Invalid credentials.']);
    }

    if (!$customer->is_verified) {
        
        $verificationCode = rand(100000, 999999);
        $customer->verification_code = $verificationCode;
        $customer->save();

        
        Mail::raw("Your verification code is: $verificationCode", function ($message) use ($customer) {
            $message->to($customer->email)
                    ->subject('Email Verification');
        });

        return back()->withErrors(['email' => 'Please verify your email. A verification code has been sent.']);

        
    }
    Auth::guard('customer')->login($customer);
    return redirect()->intended('/');
    
    
    
}


    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:50|unique:customer,username',
        'email' => 'required|email|unique:customer,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    
    $verificationCode = rand(100000, 999999);

    
    $user = Customer::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'verification_code' => $verificationCode,
        'is_verified' => false,
    ]);

    
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

        $user = Customer::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }

        
        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        return redirect('/login')->with('success', 'Email verified! You can now log in.');
    }

    public function logout(Request $request)
{
    Auth::guard('customer')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); 
}


public function loginCustomer(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('customer')->attempt($credentials)) {
        return redirect()->intended('/');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

}
