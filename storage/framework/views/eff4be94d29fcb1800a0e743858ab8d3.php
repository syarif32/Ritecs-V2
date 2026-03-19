

<?php $__env->startSection('content'); ?>

    <div class="container-fluid bg-light d-flex align-items-center justify-content-center py-5" style="min-height: 80vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card shadow-sm border-0 rounded-3">
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
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger text-center"><?php echo e($errors->first()); ?></div>
                            <?php endif; ?>

                            <form action="<?php echo e(route('otp.verify.form')); ?>" method="POST" class="mt-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">

                                <div class="mb-4">

                                    <label for="otp" class="visually-hidden">Kode OTP</label>


                                    <input type="text" id="otp" name="otp" required autofocus
                                        class="form-control form-control-lg text-center" placeholder="_ _ _ _ _ _"
                                        style="font-size: 2rem; letter-spacing: 0.5rem; font-weight: 600;">
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
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const resendContainer = document.getElementById('resend-container');
        const timerContainer = document.getElementById('timer-container');
        const resendLink = document.getElementById('resend-link');
        const timerSpan = document.getElementById('timer');
        <?php if(session('resend_timer')): ?>
            let timeLeft = <?php echo e(session('resend_timer')); ?>;
            startTimer(timeLeft);
        <?php endif; ?>

        resendLink.addEventListener('click', function(e) {
            startTimer(60); 
        });

        function startTimer(duration) {
            resendContainer.style.display = 'none';
            timerContainer.style.display = 'inline';

            let timer = duration;
            timerSpan.textContent = timer;

            const interval = setInterval(function() {
                timer--;
                timerSpan.textContent = timer;

                if (timer <= 0) {
                    clearInterval(interval);
                    timerContainer.style.display = 'none';
                    resendContainer.style.display = 'inline';
                }
            }, 1000);
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\pages\auth\otp-verify.blade.php ENDPATH**/ ?>