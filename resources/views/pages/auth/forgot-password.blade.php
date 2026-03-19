@extends('layouts.main') @section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow rounded-4 p-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Reset Password</h4>
            <p class="text-muted small">Masukkan email yang terdaftar untuk menerima link reset password.</p>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-3" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                <label for="email">Alamat Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                Kirim Link Reset
            </button>
        </form>
    </div>
</div>
@endsection