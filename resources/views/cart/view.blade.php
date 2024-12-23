@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Keranjang Belanja</h1>
    @if(session('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rp {{ number_format($item['price'], 2) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Keranjang Anda kosong.</p>
    @endif
</div>
@endsection
