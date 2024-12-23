<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan Anda mengimpor model Product
class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk dari database
        $products = Product::all();

        // Kembalikan view dengan data produk
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Kembalikan view dengan data produk
        return view('products.show', compact('product'));
    }
}
