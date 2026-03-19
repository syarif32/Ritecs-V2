<div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="#" class="navbar-brand p-0">
                <h1 class="text-primary mb-0">
                    <img src="<?php echo e(asset('assets/img/logo/logo-text.webp')); ?>" alt="Logo">
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-0 mx-lg-auto justify-content-center">
                    <a href="<?php echo e(route('home')); ?>" class="nav-item nav-link <?php echo e(($title ?? '') === 'Home' ? 'active' : ''); ?>">Beranda</a>
                    <a href="<?php echo e(route('about')); ?>#visi-misi" class="nav-item nav-link <?php echo e(($title ?? '') === 'About' ? 'active' : ''); ?>">Tentang</a>
                    <a href="<?php echo e(route('service')); ?>" class="nav-item nav-link <?php echo e(($title ?? '') === 'Service' ? 'active' : ''); ?>">Layanan</a>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link <?php echo e(in_array($title ?? '', ['Buku', 'Jurnal', 'Detail Buku', 'Awardings']) ? 'active' : ''); ?>" data-bs-toggle="dropdown">
                            <span class="dropdown-toggle">Publish</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="<?php echo e(route('buku')); ?>" class="dropdown-item <?php echo e(in_array($title ?? '', ['Buku', 'Detail Buku']) ? 'active' : ''); ?>">Buku</a>
                            <a href="<?php echo e(route('journal')); ?>" class="dropdown-item <?php echo e(in_array($title ?? '', ['Jurnal', 'Detail Jurnal']) ? 'active' : ''); ?>">Jurnal</a>
                            <a href="<?php echo e(route('awardings.index')); ?>" class="dropdown-item <?php echo e(in_array($title ?? '', ['Awardings']) ? 'active' : ''); ?>">Penghargaan</a>
                            <a href="<?php echo e(route('membership.index')); ?>" class="dropdown-item <?php echo e(($title ?? '') === 'Members' ? 'active' : ''); ?>">Anggota</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link <?php echo e(in_array($title ?? '', ['Petunjuk Penulis', 'Layanan Journal', 'Contact']) ? 'active' : ''); ?>" data-bs-toggle="dropdown">
                            <span class="dropdown-toggle">Bantuan</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="<?php echo e(route('petunjuk-penulis')); ?>#petunjuk-penulis" class="dropdown-item <?php echo e(($title ?? '') === 'Petunjuk Penulis' ? 'active' : ''); ?>">Petunjuk Penulis</a>
                            <a href="<?php echo e(route('layanan-journal')); ?>#layanan-jurnal" class="dropdown-item <?php echo e(in_array($title ?? '', ['Service', 'Layanan Journal']) ? 'active' : ''); ?>">Layanan Jurnal</a>
                            <a href="<?php echo e(route('training-center')); ?>#training" class="dropdown-item <?php echo e(($title ?? '') === 'Training Center' ? 'active' : ''); ?>">Pusat Pelatihan</a>
                            <a href="<?php echo e(route('layanan-haki')); ?>" class="dropdown-item">Layanan HAKI</a>
                            <a href="<?php echo e(route('contact.create')); ?>#contact" class="dropdown-item <?php echo e(($title ?? '') === 'Contact' ? 'active' : ''); ?>">Kontak</a>
                        </div>
                    </div>

                    <div class="nav-btn px-3">
                        <?php if(auth()->guard()->guest()): ?>
                            <button type="button" class="btn btn-dark btn-login-me rounded-pill py-2 px-4 ms-3 flex-shrink-0" data-bs-toggle="modal" data-bs-target="#authModal">
                                Masuk
                            </button>
                        <?php endif; ?>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="nav-item dropdown">
                                <a href="#" class="btn btn-dark rounded-pill py-2 px-4 ms-3 flex-shrink-0 dropdown-toggle" data-bs-toggle="dropdown">
                                    <?php echo e(Auth::user()->first_name); ?>

                                </a>
                                <div class="dropdown-menu">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Admin')): ?>
                                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="dropdown-item">Admin Dashboard</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('profile.dashboard')); ?>" class="dropdown-item">Profil Saya</a>
                                    <?php endif; ?>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="d-none d-xl-flex flex-shrink-0 ps-4">
                <a href="#" class="btn btn-light btn-lg-square rounded-circle position-relative wow tada" data-wow-delay=".9s">
                    <i class="fa fa-phone-alt fa-2x"></i>
                    <div class="position-absolute" style="top: 7px; right: 12px;">
                        <span><i class="fa fa-comment-dots text-secondary"></i></span>
                    </div>
                </a>
                <div class="d-flex flex-column ms-3">
                    <span>Call to Our Experts</span>
                    <a href="tel:<?php echo e($global_contact_phone?->value ?? ''); ?>">
                        <span class="text-dark">Free: <?php echo e($global_contact_phone?->value ?? 'Nomor belum diatur'); ?></span>
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
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="btn bg-light border nput-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="authModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 rounded-4">
            <div class="auth-container">
                <div class="auth-flipper">

                    <div class="auth-panel auth-panel-front">
                        <div class="row g-0 h-100">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="modal-body p-4 p-sm-5">
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                    
                                    <div class="text-center mb-4">
                                        <img src="<?php echo e(asset('assets/img/logo/logo-text.webp')); ?>" alt="Logo" width="72">
                                        <h2 class="fw-bold mt-3 mb-2">Selamat Datang!</h2>
                                        <p class="text-muted">Masuk untuk melanjutkan.</p>
                                    </div>

                                    
                                    <?php if(session('status')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('status')); ?>

                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST" action="<?php echo e(route('login.process')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="loginEmail" name="email" placeholder="nama@email.com" value="<?php echo e(old('email')); ?>" required>
                                            <label for="loginEmail">Alamat Email</label>
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-floating mb-2 position-relative">
    <input type="password" class="form-control" id="loginPassword"
        name="password" placeholder="Password" required style="padding-right: 40px;">
    <label for="loginPassword">Password</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('loginPassword', 'iconLoginPass')">
        <i class="fa fa-eye text-muted" id="iconLoginPass"></i>
    </span>
</div>
                                        
                                        
                                        <div class="d-flex justify-content-end mb-3">
                                            <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none small text-muted">
                                                Lupa Password?
                                            </a>
                                        </div>

                                        <div class="d-grid mb-3">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">Masuk</button>
                                        </div>
                                    </form>

                                    <div class="d-flex align-items-center my-3">
                                        <hr class="flex-grow-1">
                                        <span class="mx-3 text-muted small">ATAU</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                    <div class="d-grid">
                                        <a href="<?php echo e(route('auth.google.redirect')); ?>" class="btn btn-light border w-100 py-2 rounded-pill">
                                            <img src="https://www.google.com/favicon.ico" alt="Google icon" class="me-2" style="width: 16px;">
                                            Masuk dengan Google
                                        </a>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-muted small">Belum punya akun? <a href="#" id="showRegister" class="fw-bold text-decoration-none">Daftar di sini</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auth-panel auth-panel-back">
                        <div class="row g-0 h-100">
                            <div class="col-lg-6">
                                <div class="modal-body p-4 p-sm-5">
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <img src="<?php echo e(asset('assets/img/logo/logo-text.webp')); ?>" alt="Logo" width="72">
                                        <h2 class="fw-bold mt-3 mb-2">Buat Akun Baru</h2>
                                        <p class="text-muted">Mulai perjalanan Anda.</p>
                                    </div>

                                    <form method="POST" action="<?php echo e(route('register')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="registerFirstName" name="first_name" placeholder="Nama Depan" value="<?php echo e(old('first_name')); ?>" required>
                                            <label for="registerFirstName">Nama Depan</label>
                                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="registerLastName" name="last_name" placeholder="Nama Belakang" value="<?php echo e(old('last_name')); ?>">
                                            <label for="registerLastName">Nama Belakang</label>
                                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control <?php $__errorArgs = ['email', 'register'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="registerEmail" name="email" placeholder="nama@email.com" value="<?php echo e(old('email')); ?>" required>
                                            <label for="registerEmail">Alamat Email</label>
                                            <?php $__errorArgs = ['email', 'register'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-floating mb-3 position-relative">
    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        id="registerPassword" name="password" placeholder="Buat Password" required style="padding-right: 40px;">
    <label for="registerPassword">Buat Password</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('registerPassword', 'iconRegPass')">
        <i class="fa fa-eye text-muted" id="iconRegPass"></i>
    </span>
    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-floating mb-3 position-relative">
    <input type="password" class="form-control"
        id="registerPasswordConfirmation" name="password_confirmation"
        placeholder="Konfirmasi Password" required style="padding-right: 40px;">
    <label for="registerPasswordConfirmation">Konfirmasi Password</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('registerPasswordConfirmation', 'iconRegConfirm')">
        <i class="fa fa-eye text-muted" id="iconRegConfirm"></i>
    </span>
</div>
                                        <div class="d-grid mb-3">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">Daftar</button>
                                        </div>
                                    </form>

                                    <div class="d-flex align-items-center my-3">
                                        <hr class="flex-grow-1">
                                        <span class="mx-3 text-muted small">ATAU</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                    <div class="d-grid">
                                        <a href="<?php echo e(route('auth.google.redirect')); ?>" class="btn btn-light border w-100 py-2 rounded-pill">
                                            <img src="https://www.google.com/favicon.ico" alt="Google icon" class="me-2" style="width: 16px;">
                                            Masuk dengan Google
                                        </a>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-muted small">Sudah punya akun? <a href="#" id="showLogin" class="fw-bold text-decoration-none">Masuk di sini</a></p>
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
<!-- 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if(session('status') || $errors->any() || request()->get('auth') === 'login'): ?>
            var modal = new bootstrap.Modal(document.getElementById('authModal'));
            modal.show();
        <?php endif; ?>
    });
</script>
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
</script> --><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\partials\navbar.blade.php ENDPATH**/ ?>