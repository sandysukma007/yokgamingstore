@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Email Verification</h2>
    <form action="{{ route('verify') }}" method="POST">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" value="{{ session('email') }}" required readonly><br>

        <label>Verification Code:</label>
        <input type="text" name="verification_code" required><br>

        <button type="submit">Verify</button>
    </form>
</div>
@endsection
