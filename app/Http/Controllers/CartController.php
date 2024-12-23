<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
class CartController extends Controller
{
    public function add($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Tambahkan produk ke keranjang
        $cart = Session::get('cart', []);
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ];
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function view()
    {
        $cart = session('cart', []);
        return view('cart.view', compact('cart'));
    }
}
