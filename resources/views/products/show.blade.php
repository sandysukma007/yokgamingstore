@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->name }}">
    <p>{{ $product->description }}</p>
    <p>Harga: Rp {{ number_format($product->price, 2) }}</p>
    <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
    </form>
</div>
@endsection
