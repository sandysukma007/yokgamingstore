@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-5x text-secondary"></i>
                    <h5 class="mt-3">{{ $customer->username }}</h5>
                    <p class="text-muted"><i class="fas fa-envelope"></i> {{ $customer->email }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-gamepad"></i> Produk yang Dibeli</h4>
                </div>
                <div class="card-body">
                    @if($purchases->isEmpty())
                        <div class="alert alert-warning text-center">Anda belum membeli produk apapun.</div>
                    @else
                        <table class="table table-hover">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Link Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchase)
                                <tr>
                                    <td>
                                        <i class="fas fa-gamepad"></i> {{ $purchase->product->name }}
                                    </td>
                                    <td>
                                        <a href="{{ $purchase->product->link_download }}" class="btn btn-success btn-sm" target="_blank">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
