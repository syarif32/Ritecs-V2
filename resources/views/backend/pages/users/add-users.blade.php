@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <h2 class="h3 mb-4 page-title">Add User</h2>

      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" class="form-control" name="first_name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone">
              </div>
              <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>NIK</label>
                <input type="text" class="form-control" name="nik">
              </div>
              <div class="col-md-6 mb-3">
                <label>Birthday</label>
                <input type="date" class="form-control" name="birthday">
              </div>
              <div class="col-md-6 mb-3">
                <label>City</label>
                <input type="text" class="form-control" name="city">
              </div>
              <div class="col-md-6 mb-3">
                <label>Province</label>
                <input type="text" class="form-control" name="province">
              </div>
              <div class="col-md-12 mb-3">
                <label>Address</label>
                <textarea class="form-control" name="address"></textarea>
              </div>

              {{-- Profile Image --}}
              <div class="col-md-6 mb-3">
                <div class="form-group col-md-12 p-0">
                  <label for="profileImage" class="font-weight-bold">Profile Image</label>
                  <div class="upload-box" id="uploadProfileBox">
                      <input type="file" id="profileImage" name="profile" accept="image/*" hidden>
                      <img id="previewProfileImage"
                          src="{{ asset('assets/published/books/book_default.png') }}"
                          alt="Preview" style="max-width: 150px;">
                  </div>
                </div>
              </div>

              {{-- KTP Image --}}
              <div class="col-md-6 mb-3">
                <div class="form-group col-md-12 p-0 h-100">
                  <label for="ktpImage" class="font-weight-bold">KTP Image</label>
                  <div class="upload-box" id="uploadKtpBox">
                      <input type="file" id="ktpImage" name="ktp" accept="image/*" hidden>
                      <img id="previewKtpImage"
                          src="{{ asset('assets/published/books/book_default.png') }}"
                          alt="Preview" style="max-width: 150px;">
                  </div>
                </div>
              </div>

            </div>

            <button class="btn btn-primary" type="submit">Save</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    function setupImagePreview(inputId, previewId, boxId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const box = document.getElementById(boxId);
        if (!input || !preview || !box) return;

        // Klik pada gambar / box membuka file chooser
        box.addEventListener('click', () => input.click());

        // Tampilkan preview setelah file dipilih
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Jalankan untuk masing-masing upload box
    setupImagePreview('profileImage', 'previewProfileImage', 'uploadProfileBox');
    setupImagePreview('ktpImage', 'previewKtpImage', 'uploadKtpBox');
});
</script>
@endpush
