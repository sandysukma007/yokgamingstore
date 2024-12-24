<?php

// return [
//     'client_key' => env('MIDTRANS_CLIENT_KEY'),
//     'server_key' => env('MIDTRANS_SERVER_KEY'),
//     'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
// ];

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => true, // Ganti ke false jika masih menggunakan sandbox
];

