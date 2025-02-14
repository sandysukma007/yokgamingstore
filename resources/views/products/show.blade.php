@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card product-detail-card shadow-lg border-0">
                    <div class="row g-0">
                        <!-- Gambar Produk -->
                        <div class="col-md-6 text-center d-flex align-items-center bg-light">
                            <img src="{{ asset($product->image_url) }}" class="img-fluid product-image"
                                alt="{{ $product->name }}">
                        </div>

                        <!-- Informasi Produk -->
                        <div class="col-md-6">
                            <div class="card-body">
                                <h1 class="product-title text-primary fw-bold">{{ $product->name }}</h1>
                                <p class="product-description text-muted">{{ $product->description }}</p>
                                <h3 class="product-price text-danger fw-bold">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</h3>

                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-gradient w-100 mt-3">🛒 Tambah ke
                                        Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Kembali -->
                <!-- Tombol Kembali -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">⬅ Kembali</a>
                </div>


            </div>
        </div>
    </div>

    <style>
        /* Styling Card */
        .product-detail-card {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Styling Gambar */
        .product-image {
            max-height: 350px;
            width: auto;
            object-fit: contain;
            padding: 15px;
        }

        /* Styling Judul */
        .product-title {
            font-size: 28px;
        }

        /* Styling Deskripsi */
        .product-description {
            font-size: 16px;
            line-height: 1.6;
        }

        /* Styling Harga */
        .product-price {
            font-size: 24px;
            margin-top: 10px;
        }

        /* Button Gradient */
        .btn-gradient {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 18px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            border: none;
        }

        .btn-gradient:hover {
            background: linear-gradient(to left, #141e30, #243b55);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-title {
                font-size: 24px;
            }

            .product-price {
                font-size: 20px;
            }

            .product-description {
                font-size: 14px;
            }

            .btn-gradient {
                font-size: 16px;
                padding: 10px 15px;
            }

            .product-image {
                max-height: 250px;
            }
        }
    </style>
@endsection
