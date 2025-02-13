@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profil Saya</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $customer->username }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $customer->email }}</p>
        </div>
    </div>

    <h3>Produk yang Dibeli</h3>
    @if($purchases->isEmpty())
        <p>Anda belum membeli produk apapun.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Link Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product->name }}</td>
                    <td>
                        <a href="{{ $purchase->product->link_download }}" class="btn btn-primary" target="_blank">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
