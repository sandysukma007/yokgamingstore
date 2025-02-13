@extends('layouts.app')

@section('content')
<div class="container">

    @if(!auth()->check())
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif

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
                    <td>
                        <form action="{{ route('cart.delete', $id) }}" method="POST">
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
        <p>Keranjang Anda kosong.</p>
    @endif
</div>
@endsection
