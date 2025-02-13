@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 15px;">
        <h2 class="text-center text-primary fw-bold">📝 Register</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan username">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Buat password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <hr>
        <p class="text-center text-muted">Sudah punya akun?</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Login</a>
    </div>
</div>

<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
    }

    .card {
        background: white;
        border-radius: 15px;
    }
</style>
@endsection
