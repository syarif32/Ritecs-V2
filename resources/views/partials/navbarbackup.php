Navbar & Hero Start
<div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="#" class="navbar-brand p-0">
                <h1 class="text-primary mb-0 "> <img src="{{ asset('assets/img/logo/logo-text.webp') }}" alt="Logo"></i>
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-0 mx-lg-auto justify-content-center">
                    <a href="{{ route('home') }}"
                        class="nav-item nav-link {{ ($title ?? '') === 'Home' ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}#visi-misi"
                        class="nav-item nav-link {{ ($title ?? '') === 'About' ? 'active' : '' }}">
                        Tentang
                    </a>
                    <a href="{{ route('service') }}"
                        class="nav-item nav-link {{ ($title ?? '') === 'Service' ? 'active' : '' }}">Layanan</a>
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-item nav-link {{ in_array($title ?? '', ['Buku', 'Jurnal', 'Detail Buku', 'Awardings']) ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <span class="dropdown-toggle">Publish</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('buku') }}"
                                class="dropdown-item {{ in_array($title ?? '', ['Buku', 'Detail Buku']) ? 'active' : '' }}">Buku</a>
                            <a href="{{ route('journal') }}"
                                class="dropdown-item {{ in_array($title ?? '', ['Jurnal', 'Detail Jurnal']) ? 'active' : '' }}">Jurnal</a>
                            <a href="{{ route('awardings.index') }}"
                                class="dropdown-item {{ in_array($title ?? '', ['Awardings']) ? 'active' : '' }}">Penghargaan</a>
                                <a href="{{ route('membership.index') }}" 
       class="dropdown-item {{ ($title ?? '') === 'Members' ? 'active' : '' }}">Anggota</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-item nav-link {{ in_array($title ?? '', ['Petunjuk Penulis', 'Layanan Journal', 'Contact']) ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <span class="dropdown-toggle">Bantuan</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('petunjuk-penulis') }}#petunjuk-penulis"
                                class="dropdown-item {{ ($title ?? '') === 'Petunjuk Penulis' ? 'active' : '' }}">Petunjuk
                                Penulis</a>
                            <a href="{{ route('layanan-journal') }}#layanan-jurnal"
                                class="dropdown-item {{ in_array($title ?? '', ['Service', 'Layanan Journal']) ? 'active' : '' }}">Layanan
                                Jurnal
                            </a>
                            <a href="{{ route('layanan-journal') }}
#layanan-jurnal" class="dropdown-item d-none {{ ($title ?? '') === 'Layanan Jurnal' ? 'active' : '' }}">Layanan
                                Jurnal
                            </a>
                            <a href="{{ route('training-center') }}#training"
                                class="dropdown-item {{ ($title ?? '') === 'Training Center' ? 'active' : '' }}">Pusat
                                Pelatihan
                            </a>
                            <a href="{{ route('layanan-haki') }}" class="dropdown-item">Layanan HAKI</a>
                            <a href="{{ route('contact.create') }}#contact"
                                class="dropdown-item {{ ($title ?? '') === 'Contact' ? 'active' : '' }}">Kontak</a>
                        </div>
                    </div>

                    <div class="nav-btn px-3">
                        <!-- <button class="btn-search btn btn-primary btn-md-square rounded-circle flex-shrink-0"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search"></i></button> -->

                        @guest
                            {{-- Tampilkan tombol "Masuk" jika pengguna adalah tamu (belum login) --}}
                            <button type="button"
                                class="btn btn-dark btn-login-me rounded-pill py-2 px-4 ms-3 flex-shrink-0"
                                data-bs-toggle="modal" data-bs-target="#authModal">
                                Masuk
                            </button>
                        @endguest

                        @auth
                            <div class="nav-item dropdown">
                                <a href="#" class="btn btn-dark rounded-pill py-2 px-4 ms-3 flex-shrink-0 dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->first_name }}
                                </a>
                                <div class="dropdown-menu">

                                    @role('Admin')
                                   
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin Dashboard</a>
                        @else                                      
                                            <a href="{{ route('profile.dashboard') }}" class="dropdown-item">Profil Saya</a>
                                            @endrole
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                            </form>
                                        </div>
                                    </div>
                                @endauth
                    </div>
                </div>
            </div>
            <div class="d-none d-xl-flex flex-shrink-0 ps-4">
                <a href="#" class="btn btn-light btn-lg-square rounded-circle position-relative wow tada"
                    data-wow-delay=".9s">
                    <i class="fa fa-phone-alt fa-2x"></i>
                    <div class="position-absolute" style="top: 7px; right: 12px;">
                        <span><i class="fa fa-comment-dots text-secondary"></i></span>
                    </div>
                </a>
                <div class="d-flex flex-column ms-3">
                    <span>Call to Our Experts</span>
                   <a href="tel:{{ $global_contact_phone?->value ?? '' }}">
    <span class="text-dark">
        Free: {{ $global_contact_phone?->value ?? 'Nomor belum diatur' }}
    </span>
</a>
                </div>


            </div>
        </nav>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center bg-primary">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords"
                        aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="btn bg-light border nput-group-text p-3"><i
                            class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    </div>
  <div class="modal fade" id="authModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 rounded-4">
            <div class="auth-container">
                <div class="auth-flipper">

                    <div class="auth-panel auth-panel-front">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="modal-body p-4 p-sm-5">
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <img src="assets/img/logo/logo-text.webp" alt="Logo" width="72">
                                        <h2 class="fw-bold mt-3 mb-2">Selamat Datang!</h2>
                                        <p class="text-muted">Masuk untuk melanjutkan.</p>
                                    </div>
                                    </div> @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
                                    <form method="POST" action="{{ route('login.process') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="loginEmail" name="email" placeholder="nama@email.com"
                                                value="{{ old('email') }}" required>
                                            <label for="loginEmail">Alamat Email</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="loginPassword"
                                                name="password" placeholder="Password" required>
                                            <label for="loginPassword">Password</label>
                                        </div>
                                        <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">
                            Lupa Password?
                        </a>
                    </div>
                                        <div class="d-grid mb-3">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg rounded-pill fw-bold">Masuk</button>
                                        </div>
                                    </form>

                                    <div class="d-flex align-items-center my-3">
                                        <hr class="flex-grow-1">
                                        <span class="mx-3 text-muted small">ATAU</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('auth.google.redirect') }}"
                                            class="btn btn-light border w-100 py-2 rounded-pill">
                                            <img src="https://www.google.com/favicon.ico" alt="Google icon" class="me-2"
                                                style="width: 16px;">
                                            Masuk dengan Google
                                        </a>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-muted small">Belum punya akun? <a href="#" id="showRegister"
                                                class="fw-bold text-decoration-none">Daftar di sini</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auth-panel auth-panel-back">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="modal-body p-4 p-sm-5">
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <img src="assets/img/logo/logo-text.webp" alt="Logo" width="72">
                                        <h2 class="fw-bold mt-3 mb-2">Buat Akun Baru</h2>
                                        <p class="text-muted">Mulai perjalanan Anda.</p>
                                    </div>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="registerFirstName" name="first_name" placeholder="Nama Depan"
                                                value="{{ old('first_name') }}" required>
                                            <label for="registerFirstName">Nama Depan</label>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                id="registerLastName" name="last_name" placeholder="Nama Belakang"
                                                value="{{ old('last_name') }}">
                                            <label for="registerLastName">Nama Belakang</label>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email"
                                                class="form-control @error('email', 'register') is-invalid @enderror"
                                                id="registerEmail" name="email" placeholder="nama@email.com"
                                                value="{{ old('email') }}" required>
                                            <label for="registerEmail">Alamat Email</label>
                                            @error('email', 'register')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="registerPassword" name="password" placeholder="Buat Password"
                                                required>
                                            <label for="registerPassword">Buat Password</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control"
                                                id="registerPasswordConfirmation" name="password_confirmation"
                                                placeholder="Konfirmasi Password" required>
                                            <label for="registerPasswordConfirmation">Konfirmasi Password</label>
                                        </div>
                                        <div class="d-grid mb-3">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg rounded-pill fw-bold">Daftar</button>
                                        </div>
                                    </form>

                                    <div class="d-flex align-items-center my-3">
                                        <hr class="flex-grow-1">
                                        <span class="mx-3 text-muted small">ATAU</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('auth.google.redirect') }}"
                                            class="btn btn-light border w-100 py-2 rounded-pill">
                                            <img src="https://www.google.com/favicon.ico" alt="Google icon" class="me-2"
                                                style="width: 16px;">
                                            Masuk dengan Google
                                        </a>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-muted small">Sudah punya akun? <a href="#" id="showLogin"
                                                class="fw-bold text-decoration-none">Masuk di sini</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-none d-lg-block bg-register-image"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->

<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center bg-primary">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords"
                        aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="btn bg-light border nput-group-text p-3"><i
                            class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->

@if(request()->get('auth') === 'login')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var modal = new bootstrap.Modal(document.getElementById('authModal'));
            modal.show();
        });
    </script>
@endif