<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) // Pastikan ada Request $request di sini
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        $products = $query->paginate(10);

        if ($request->ajax()) {
            return view('products.list', compact('products'))->render();
        }

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
