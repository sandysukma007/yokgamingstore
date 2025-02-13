<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Purchase; // Model untuk menyimpan produk yang sudah dibeli

class CustomerController extends Controller
{
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        $purchases = $customer->purchases; // Produk yang sudah dibeli
        
        return view('customer.profile', compact('customer', 'purchases'));
    }
}
