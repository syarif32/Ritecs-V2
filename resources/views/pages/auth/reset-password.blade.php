@extends('layouts.main') @section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow rounded-4 p-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Password Baru</h4>
            <p class="text-muted small">Silakan buat password baru Anda.</p>
        </div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ $email ?? old('email') }}" readonly>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3 position-relative">
    <input type="password" class="form-control @error('password') is-invalid @enderror" 
           id="resetPassword" name="password" placeholder="Password Baru" required style="padding-right: 40px;">
    <label for="resetPassword">Password Baru</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('resetPassword', 'iconResetPass')">
        <i class="fa fa-eye text-muted" id="iconResetPass"></i>
    </span>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-4 position-relative">
    <input type="password" class="form-control" 
           id="resetPasswordConfirm" name="password_confirmation" placeholder="Konfirmasi Password" required style="padding-right: 40px;">
    <label for="resetPasswordConfirm">Ulangi Password</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('resetPasswordConfirm', 'iconResetConfirm')">
        <i class="fa fa-eye text-muted" id="iconResetConfirm"></i>
    </span>
</div>
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                Ubah Password
            </button>
        </form>
    </div>
</div>
@endsection
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash"); 
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye"); 
        }
    }
</script>