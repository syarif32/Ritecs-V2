

<?php $__env->startSection('content'); ?>

    <div class="container-fluid bg-light d-flex align-items-center justify-content-center py-5" style="min-height: 80vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card shadow-sm border-0 rounded-3 position-relative">
                        <div class="position-absolute top-0 end-0 p-4">
    <button type="button" 
            class="btn btn-sm btn-outline-secondary rounded-pill shadow-sm px-3 d-flex align-items-center gap-2" 
            data-bs-toggle="modal" 
            data-bs-target="#otpRulesModal"
            style="background: white;">
        <i class="fas fa-question-circle text-primary"></i>
        <span class="fw-semibold small">Bantuan & Aturan</span>
    </button>
</div>
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <div class="feature-icon p-4 d-inline-flex mx-auto mb-4"
                                    style="background-color: rgba(1, 95, 201, 0.1);">
                                    <i class="fas fa-envelope-open-text fa-3x text-primary"></i>
                                </div>

                                <h2 class="h2 text-dark fw-bold">Verifikasi Email Anda</h2>
                                <p class="text-muted">
                                    Kami telah mengirimkan 6 digit kode verifikasi ke email Anda. Silakan masukkan kode
                                    tersebut di bawah ini untuk mengaktifkan akun Anda.
                                </p>
                            </div>

                            <?php if(session('success')): ?>
                                <div class="alert alert-success text-center"><?php echo e(session('success')); ?></div>
                            <?php endif; ?>
                            <?php if(session('error')): ?>
                                <div class="alert alert-danger text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger text-center"><?php echo e($errors->first()); ?></div>
                            <?php endif; ?>

                            <form action="<?php echo e(route('otp.verify.form')); ?>" method="POST" class="mt-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">

                                <div class="mb-4">
                                    <label for="otp" class="visually-hidden">Kode OTP</label>

                                    <input type="text" id="otp" name="otp" required autofocus
                                        class="form-control form-control-lg text-center <?php if($errors->otp_errors->has('otp')): ?> is-invalid <?php endif; ?>" 
                                        placeholder="_ _ _ _ _ _"
                                        value="<?php echo e(old('otp')); ?>"
                                        style="font-size: 2rem; letter-spacing: 0.5rem; font-weight: 600;">

                                    <?php if($errors->otp_errors->has('otp')): ?>
                                        <div class="invalid-feedback text-center" style="display: block; font-size: 1rem; margin-top: 10px;">
                                            <strong><?php echo e($errors->otp_errors->first('otp')); ?></strong>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                        Verifikasi Akun
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted small">
                                    Tidak menerima kode?
                                    <span id="resend-container">
                                        <a href="<?php echo e(route('otp.resend', ['userId' => $user_id])); ?>" id="resend-link"
                                            class="fw-bold">Kirim ulang</a>
                                    </span>
                                    <span id="timer-container" style="display: none;">
                                        Kirim ulang dalam <span id="timer" class="fw-bold">60</span> detik
                                    </span>
                                </p>

                                <div class="mt-4 text-center" id="manual-help-container" style="display: none; animation: fadeIn 2s;">
                                    <p class="text-muted mb-2 small">Tidak menerima kode sama sekali?</p>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#manualActivationModal" 
                                       class="btn btn-outline-danger btn-sm rounded-pill px-4">
                                       <i class="fas fa-user-shield me-2"></i> Minta Bantuan Aktivasi Admin
                                    </a>
                                </div>

                                <div class="modal fade" id="manualActivationModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="<?php echo e(route('otp.request.manual')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-light">
                                                    <h6 class="modal-title fw-bold text-dark">
                                                        <i class="fas fa-life-ring me-2"></i>Bantuan Aktivasi
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="alert alert-warning d-flex align-items-center small" role="alert">
                                                        <i class="fas fa-info-circle fa-lg me-3"></i>
                                                        <div>
                                                            Permintaan ini akan dikirim ke Admin. Proses pengecekan dan aktivasi minimal 1x24 Jam.
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-muted text-start d-block">Apa kendala yang Anda alami?</label>
                                                        <select class="form-select" name="reason" id="reasonSelect" required>
                                                            <option value="" selected disabled>Pilih kendala...</option>
                                                            <option value="Email Penuh">Email penuh (Storage Full)</option>
                                                            <option value="Tidak Masuk Spam">Tidak menerima email (Inbox/Spam kosong)</option>
                                                            <option value="Salah Email">Typo/Salah tulis email saat daftar</option>
                                                            <option value="Lainnya">Lainnya (Tuliskan detail)</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 d-none" id="otherReasonContainer">
                                                        <label class="form-label small fw-bold text-muted text-start d-block">Jelaskan masalah Anda:</label>
                                                        <textarea class="form-control" name="other_reason_detail" id="otherReasonInput" rows="2" 
                                                                  placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-link text-muted text-decoration-none btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill" id="btnSubmitRequest">
                                                        <span class="btn-text">Kirim Permintaan</span>
                                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
  
  
  
  
<div class="modal fade" id="otpRulesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Panduan Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4 text-start"> 
                
                
                <ol class="list-group list-group-numbered border-0 mb-0">
                    
                    
                    <li class="list-group-item border-0 px-0 pb-3">
                        <span class="fw-bold text-dark">Periksa Folder Lain</span>
                        <div class="ms-1 mt-1 text-muted small">
                            Kode OTP seringkali tidak masuk ke Inbox utama. Pastikan Anda mengecek:
                            <ul class="mt-1 mb-0" style="list-style-type: disc;"> 
                                <li>Folder <b>Spam</b> atau <b>Junk</b>.</li>
                                <li>Tab <b>Promotions</b> (jika menggunakan Gmail).</li>
                            </ul>
                        </div>
                    </li>

                    
                    <li class="list-group-item border-0 px-0 pb-3">
                        <span class="fw-bold text-dark">Cek Penyimpanan (Storage)</span>
                        <div class="ms-1 mt-1 text-muted small">
                            Pastikan penyimpanan Google Drive/iCloud Anda <b>tidak penuh</b>. Jika kapasitas penuh, email baru (termasuk OTP) akan ditolak oleh sistem email Anda.
                        </div>
                    </li>

                    
                    <li class="list-group-item border-0 px-0 pb-3">
                        <span class="fw-bold text-dark">Validasi Penulisan Email</span>
                        <div class="ms-1 mt-1 text-muted small">
                            Periksa kembali apakah ada kesalahan ketik (typo) saat pendaftaran.
                            <br>Contoh salah: <i>nama@gmial.com</i> (huruf terbalik).
                        </div>
                    </li>

                </ol>

                
                <div class="alert alert-danger mt-2 mb-4" role="alert">
                    <div class="d-flex">
                        <div class="fw-bold me-2">4.</div>
                        <div>
                            <span class="fw-bold d-block">Batas Kirim Ulang (Limitasi)</span>
                            <span class="small opacity-75">
                                Demi keamanan, sistem membatasi permintaan OTP maksimal <b>3 kali dalam 24 jam</b>. 
                                <br>
                                <i class="fas fa-exclamation-circle me-1 mt-2"></i> 
                                Jika batas ini terlewati, akun akan terkunci sementara hingga esok hari.
                            </span>
                        </div>
                    </div>
                </div>

                
                <div id="manual-activation-container" style="display: none; margin-top: 20px; text-align: center;">
    <p class="text-muted mb-2">Masih belum menerima kode?</p>
    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manualActivationModal">
        Ajukan Aktivasi Manual
    </button>
</div>

            </div>
        </div>
    </div>
</div>                             
                            
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    
    <form id="logout-form-manual" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
    
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ============================================================
        // 1. AMBIL DATA DARI SERVER DENGAN AMAN (ANTI ERROR)
        // ============================================================
        // Kita simpan status session ke variabel JS di baris ini saja.
        // Jika ada session, nilainya angka. Jika tidak, nilainya null.
        let sessionResendTimer = <?php echo e(session('resend_timer') ? session('resend_timer') : 'null'); ?>;
        
        // Element Setup
        const resendContainer = document.getElementById('resend-container');
        const timerContainer = document.getElementById('timer-container');
        const resendLink = document.getElementById('resend-link');
        const timerSpan = document.getElementById('timer');
        const helpContainer = document.getElementById('manual-help-container');
        
        // Pastikan container manual sembunyi saat awal load
        if(helpContainer) helpContainer.style.display = 'none';

        // ============================================================
        // 2. LOGIKA UTAMA (SEKARANG DITANGANI JAVASCRIPT)
        // ============================================================
        
        if (sessionResendTimer !== null) {
            // --- SKENARIO 1: USER BARU SAJA KLIK RESEND (Timer Aktif) ---
            
            // A. Jalankan Timer Visual
            startTimer(sessionResendTimer);

            // B. Set Waktu Muncul Tombol Manual
            setTimeout(function() {
                if (helpContainer) {
                    helpContainer.style.display = 'block';
                    // Animasi fade-in
                    helpContainer.style.opacity = 0;
                    let op = 0.1;
                    let fadeTimer = setInterval(function () {
                        if (op >= 1){ clearInterval(fadeTimer); }
                        helpContainer.style.opacity = op;
                        op += op * 0.1;
                    }, 50);
                }
            }, sessionResendTimer * 1000);

        } else {
            // --- SKENARIO 2: HALAMAN AWAL (Bukan hasil Resend) ---
            if(timerContainer) timerContainer.style.display = 'none';
            if(resendContainer) resendContainer.style.display = 'inline';
        }

        // --- FUNGSI PENGHITUNG MUNDUR ---
        function startTimer(duration) {
            if(resendContainer) resendContainer.style.display = 'none';
            if(timerContainer) timerContainer.style.display = 'inline';
            if(helpContainer) helpContainer.style.display = 'none';

            let timer = duration;
            if(timerSpan) timerSpan.textContent = timer;

            const interval = setInterval(function() {
                timer--;
                if(timerSpan) timerSpan.textContent = timer;

                if (timer <= 0) {
                    clearInterval(interval);
                    if(timerContainer) timerContainer.style.display = 'none';
                    if(resendContainer) resendContainer.style.display = 'inline';
                    // Catatan: Tombol manual muncul via setTimeout di atas
                }
            }, 1000);
        }

        // ============================================================
        // 3. LOGIKA LAINNYA (ALERT & MODAL) - TIDAK DIUBAH
        // ============================================================
        
        <?php if(session('activation_success')): ?>
            Swal.fire({
                title: 'Berhasil Terkirim!',
                text: "<?php echo e(session('activation_success')); ?>",
                icon: 'success',
                confirmButtonText: 'OK, Kembali ke Beranda',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang keluar...',
                        text: 'Mengalihkan ke halaman utama.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => { Swal.showLoading(); }
                    });
                    document.getElementById('logout-form-manual').submit();
                }
            });
        <?php endif; ?>

        const reasonSelect = document.getElementById('reasonSelect');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        const otherReasonInput = document.getElementById('otherReasonInput');

        if(reasonSelect) {
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    otherReasonContainer.classList.remove('d-none');
                    otherReasonInput.setAttribute('required', 'required');
                    otherReasonInput.focus();
                } else {
                    otherReasonContainer.classList.add('d-none');
                    otherReasonInput.removeAttribute('required');
                    otherReasonInput.value = '';
                }
            });
        }

        const manualModal = document.getElementById('manualActivationModal');
        if(manualModal) {
            const formRequest = manualModal.querySelector('form');
            const btnSubmit = document.getElementById('btnSubmitRequest');
            if(formRequest && btnSubmit) {
                const btnText = btnSubmit.querySelector('.btn-text');
                const btnSpinner = btnSubmit.querySelector('.spinner-border');
                formRequest.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    if(btnText) btnText.textContent = 'Mengirim...';
                    if(btnSpinner) btnSpinner.classList.remove('d-none');
                });
            }
        }
        
        if(resendLink) {
            resendLink.addEventListener('click', function(e) {
                this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
                this.style.pointerEvents = 'none';
            });
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/auth/otp-verify.blade.php ENDPATH**/ ?>