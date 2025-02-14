<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function add($id)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $product = Product::findOrFail($id);
        $customer_id = Auth::guard('customer')->id();
    
        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('customer_id', $customer_id)
                        ->where('product_id', $id)
                        ->first();
    
        if ($cartItem) {
            // Jika sudah ada, tambah jumlahnya
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, tambahkan ke database
            Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }
    
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function cartItemCount()
{
    return response()->json(['cart_count' => session('cart_count', 0)]);
}


public function view()
{
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $customer_id = Auth::guard('customer')->id();
    
    // Ambil semua item dalam keranjang untuk customer yang sedang login
    $cartItems = Cart::where('customer_id', $customer_id)
                     ->with('product') // Pastikan ada relasi product
                     ->get();

    return view('cart.view', compact('cartItems'));
}



public function delete($id)
{
    $customer = Auth::guard('customer')->user();

    if (!$customer) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Hapus item dari database berdasarkan customer_id & id keranjang
    $deleted = Cart::where('id', $id)
        ->where('customer_id', $customer->user_id)
        ->delete();

    if ($deleted) {
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    } else {
        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang!');
    }
}


}
