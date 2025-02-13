<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log; // Add this line
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
class PaymentController extends Controller
{
    // public function __construct()
    // {
    //     // Set Midtrans configuration
    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$clientKey = config('midtrans.client_key');
    //     Config::$isProduction = config('midtrans.is_production');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;
    // }

    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = true; // Pastikan ini true untuk mode production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }


    // public function createPayment(Request $request)
    // {
    //     // Ambil data dari keranjang
    //     $cart = session('cart', []);
    //     if (empty($cart)) {
    //         return response()->json(['error' => 'Keranjang kosong'], 400);
    //     }

    //     // Buat data item dan total jumlah
    //     $items = [];
    //     $grossAmount = 0;

    //     foreach ($cart as $item) {
    //         $items[] = [
    //             'id' => $item['id'] ?? uniqid(),
    //             'price' => $item['price'],
    //             'quantity' => $item['quantity'],
    //             'name' => $item['name'],
    //         ];
    //         $grossAmount += $item['price'] * $item['quantity'];
    //     }

    //     // Buat transaksi
    //     $transactionData = [
    //         'transaction_details' => [
    //             'order_id' => 'ORDER-' . uniqid(),
    //             'gross_amount' => $grossAmount,
    //         ],
    //         'item_details' => $items,
    //         'customer_details' => [
    //             'first_name' => $request->input('first_name', 'John'),
    //             'last_name' => $request->input('last_name', 'Doe'),
    //             'email' => $request->input('email', 'john.doe@example.com'),
    //             'phone' => $request->input('phone', '08123456789'),
    //         ],
    //     ];

    //     // Logging untuk debugging
    //     Log::info('Midtrans Transaction Data', $transactionData); // Use Log facade

    //     // Dapatkan Snap Token untuk pembayaran
    //     try {
    //         $snapToken = Snap::getSnapToken($transactionData);
    //         return view('payment', ['snapToken' => $snapToken]);
    //     } catch (\Exception $e) {
    //         Log::error('Midtrans Error: ' . $e->getMessage()); // Use Log facade
    //         return response()->json(['error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
    //     }
    // }


    public function createPayment(Request $request)
{
    // Pastikan customer sudah login
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data customer yang sedang login
    $customer = Auth::guard('customer')->user();

    // Ambil data keranjang dari database berdasarkan `user_id` customer yang sedang login
    $cartItems = Cart::where('customer_id', $customer->user_id)->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['error' => 'Keranjang kosong'], 400);
    }

    // Buat data item dan total jumlah
    $items = [];
    $grossAmount = 0;

    foreach ($cartItems as $item) {
        $items[] = [
            'id' => $item->product_id,
            'price' => $item->product->price,
            'quantity' => $item->quantity,
            'name' => $item->product->name,
        ];
        $grossAmount += $item->product->price * $item->quantity;
    }

    // Buat transaksi
    $transactionData = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . uniqid(),
            'gross_amount' => $grossAmount,
        ],
        'item_details' => $items,
        'customer_details' => [
            'first_name' => $customer->username, // Menggunakan username sebagai nama pertama
            'last_name' => '',
            'email' => $customer->email,
            'phone' => $customer->phone ?? '08123456789',
        ],
    ];

    // Logging untuk debugging
    Log::info('Midtrans Transaction Data', $transactionData);

    // Dapatkan Snap Token untuk pembayaran
    try {
        $snapToken = Snap::getSnapToken($transactionData);
        return view('payment', ['snapToken' => $snapToken]);
    } catch (\Exception $e) {
        Log::error('Midtrans Error: ' . $e->getMessage());
        return response()->json(['error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
    }
}


    public function getTransactionDetails($transactionId)
    {
        $url = 'https://api.sandbox.midtrans.com/v2/' . $transactionId . '/status';
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':'),
        ])->get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            Log::error('Midtrans Transaction Details Error: ' . $response->body()); // Use Log facade
            return response()->json(['error' => 'Gagal mendapatkan detail transaksi'], $response->status());
        }
    }

    public function searchPromo($promoId)
    {
        $url = 'https://api.sandbox.midtrans.com/v2/promos/' . $promoId;
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':'),
        ])->get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            Log::error('Midtrans Promo Search Error: ' . $response->body()); // Use Log facade
            return response()->json(['error' => 'Gagal mencari promo'], $response->status());
        }
    }
}
