 <?php $__env->startSection('content'); ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow rounded-4 p-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Password Baru</h4>
            <p class="text-muted small">Silakan buat password baru Anda.</p>
        </div>
        <form method="POST" action="<?php echo e(route('password.update')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="<?php echo e($token); ?>">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo e($email ?? old('email')); ?>" readonly>
                <label for="email">Email</label>
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
           id="resetPassword" name="password" placeholder="Password Baru" required style="padding-right: 40px;">
    <label for="resetPassword">Password Baru</label>
    <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
          style="cursor: pointer; z-index: 10;"
          onclick="togglePassword('resetPassword', 'iconResetPass')">
        <i class="fa fa-eye text-muted" id="iconResetPass"></i>
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
<?php $__env->stopSection(); ?>
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
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\pages\auth\reset-password.blade.php ENDPATH**/ ?>