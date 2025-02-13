@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    @if(!auth('customer')->check())
        <script>
            window.location.href = "{{ route('login') }}";
        </script>
    @endif

    <h1>Keranjang Belanja</h1>

    @if($cartItems->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cart)
                    <tr>
                        <td>{{ $cart->product->name }}</td>
                        <td>Rp {{ number_format($cart->product->price, 2, ',', '.') }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>Rp {{ number_format($cart->product->price * $cart->quantity, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.delete', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('payment.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
        </form>

    @else
        <p class="text-muted">Keranjang Anda kosong.</p>
    @endif

</div>
@endsection
