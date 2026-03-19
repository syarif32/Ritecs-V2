{{-- resources/views/profile/settings.blade.php --}}
@extends('layouts.profile')

@section('content')
<div class="d-flex justify-content-between w-100 flex-wrap-reverse">
    <span class="text-dark d-flex">
        <div class="img-profile d-grid justify-content-start">
            <img id="avatarPreview"
                src="{{ $user->img_path ? asset(str_replace('\\','/',$user->img_path)) : asset('assets/users/profile/profile_default.jpg') }}"
                class="bg-dark rounded object-fit-cover img-profile-profile" alt="">

            {{-- Tombol Ubah / Simpan --}}
            <div class="d-grid gap-2 mt-1">
                <button id="btnAvatarToggle" type="button" class="btn btn-link p-0 small normal-text text-start m-auto">
                    <i class="bi bi-pencil-square me-1 small"></i><span class="small">Ubah</span>
                </button>
                <button id="btnAvatarCancel" type="button" class="btn btn-link p-0 small text-danger d-none">
                    <i class="bi bi-x-circle me-1 small"></i><span class="small">Batal</span>
                </button>
            </div>

            {{-- Form avatar --}}
            <form id="avatarForm" class="d-none" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input id="avatarInput" type="file" name="avatar" accept="image/*" class="d-none">
            </form>
        </div>

        <div class="nama-profile ms-2">
            <h5 class="mb-0 fw-bold">{{ $user->full_name }}</h5>
            @if($membership)
                <span class="normal-text text-member bg-primary small">Membership Aktif</span>
            @else
                <span class="normal-text text-member bg-warning small">Membership NonAktif</span>
            @endif
        </div>
    </span>

    <span class="d-flex flex-nowrap text-nowrap small mb-4">
        <a href="#" class="normal-text">Profile/</a>
        <a href="#" class="text-dark">Settings</a>
    </span>
</div>


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
  <strong>Data diubah</strong> update berhasil.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
  <strong>Data tidak diubah</strong> update gagal.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="settings my-4 p-3 p-md-4 pt-4 pt-md-4 bg-light rounded">
    <h5 class="fw-bold mb-1 mt-0">Ubah Data Diri</h5>
    <p class="normal-text mb-4">Data lengkap diperlukan untuk proses pengunggahan Jurnal atau Buku</p>

    <div class="form-container p-0">
        <form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="firstname" name="first_name"
                               value="{{ old('first_name', $user->first_name) }}" required>
                        <label for="firstname">Nama Depan <sup class="text-danger">*</sup></label>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="lastname" name="last_name"
                               value="{{ old('last_name', $user->last_name) }}">
                        <label for="lastname">Nama Belakang</label>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="NIK" name="nik"
                               value="{{ old('nik', $user->nik) }}">
                        <label for="NIK">NIK</label>
                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday"
                               value="{{ old('birthday', $user->birthday) }}">
                        <label for="birthday">Tanggal Lahir</label>
                        @error('birthday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                               value="{{ old('email', $user->email) }}" required>
                        <label for="email">Email <sup class="text-danger">*</sup></label>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <label for="password">Password (kosongkan jika tidak diubah)</label>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                               value="{{ old('address', $user->address) }}">
                        <label for="address">Alamat</label>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                               value="{{ old('phone', $user->phone) }}">
                        <label for="phone">Nomor Telepon</label>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city"
                               value="{{ old('city', $user->city) }}">
                        <label for="city">Kota</label>
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('province') is-invalid @enderror" id="province" name="province"
                               value="{{ old('province', $user->province) }}">
                        <label for="province">Provinsi</label>
                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('institution') is-invalid @enderror" id="institution" name="institution"
                               value="{{ old('institution', $user->institution) }}">
                        <label for="institution">Institution</label>
                        @error('institution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3 position-relative">
                <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative" 
                    style="cursor:pointer;" 
                    onclick="document.getElementById('ktp').click()">
                    
                    @if($user->ktp_path)
                        <img id="ktpPreview" src="{{ asset($user->ktp_path) }}" 
                            class="img-fluid rounded mb-2" style="max-height:200px;" alt="KTP Preview">
                    @else
                        <div id="ktpPlaceholder">
                            <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                            <p class="text-muted mb-0">Klik untuk mengunggah KTP</p>
                        </div>
                    @endif

                    <input type="file" 
                        class="form-control d-none @error('ktp_path') is-invalid @enderror" 
                        id="ktp" name="ktp_path" accept="image/*" 
                        onchange="previewKTP(this)">
                </div>
                @error('ktp_path') 
                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                @enderror

                @if($user->ktp_path)
                <a href="{{ route('profile.ktp.delete') }}" 
                        class="btn btn-sm fw-normal btn-warning m-2 px-2 position-absolute end-0 bottom-0"
                        onclick="return confirm('Hapus KTP ini?')">
                        <i class="bi bi-trash me-1"></i> Hapus KTP
                        </a>
                @endif
            </div>

            <div class="footer-form mt-4">
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="d-flex w-100 justify-content-between gap-2">
                            <button type="submit" class="btn btn-dark rounded-pill w-100 px-4">Ubah Data Diri</button>
                            <a href="{{ route('profile.settings') }}" class="btn btn-outline-dark rounded-pill w-100 px-4">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnAvatarToggle');
    const btnCancel = document.getElementById('btnAvatarCancel');
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    const avatarPreview = document.getElementById('avatarPreview');
    const originalAvatar = avatarPreview.src; // simpan avatar lama

    let mode = 'ubah'; // 'ubah' | 'siap-simpan'

    btnToggle.addEventListener('click', function (e) {
        e.preventDefault();
        if (mode === 'ubah') {
            avatarInput.click();
        } else {
            avatarForm.submit();
        }
    });

    avatarInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            avatarPreview.src = url;

            btnToggle.innerHTML = '<i class="bi bi-check2 me-1 small"></i><span class="small">Simpan</span>';
            btnCancel.classList.remove('d-none');
            mode = 'siap-simpan';
        }
    });

    btnCancel.addEventListener('click', function (e) {
        e.preventDefault();
        // reset preview
        avatarPreview.src = originalAvatar;
        avatarInput.value = '';

        // reset tombol
        btnToggle.innerHTML = '<i class="bi bi-pencil-square me-1 small"></i><span class="small">Ubah</span>';
        btnCancel.classList.add('d-none');
        mode = 'ubah';
    });
});

</script>

<script>
function previewKTP(input) {
    const preview = document.getElementById('ktpPreview');
    const placeholder = document.getElementById('ktpPlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            if (preview) {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = "ktpPreview";
                img.src = e.target.result;
                img.classList.add("img-fluid","rounded","mb-2");
                img.style.maxHeight = "200px";
                placeholder.replaceWith(img);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


@endsection
