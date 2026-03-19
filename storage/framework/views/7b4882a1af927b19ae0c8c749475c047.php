<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo e(asset('assets/lib/wow/wow.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/lib/easing/easing.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/lib/waypoints/waypoints.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/lib/counterup/counterup.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/lib/lightbox/js/lightbox.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/lib/owlcarousel/owl.carousel.min.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        // Pengecekan null safety
        if (input && icon) {
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
    }
</script>

<?php if(auth()->guard()->check()): ?>
    
    <form id="logout-form-trigger" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>

    <?php if(session('activation_success')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Permintaan Terkirim!',
                    text: "<?php echo e(session('activation_success')); ?>",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                        Swal.fire({
                            title: 'Sedang keluar...',
                            text: 'Mengalihkan ke halaman utama.',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        document.getElementById('logout-form-trigger').submit();
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php endif; ?>
<?php if(auth()->guard()->guest()): ?>
    <?php
       
        $currentRoute = request()->route() ? request()->route()->getName() : '';
        
        
        $blacklistedRoutes = [
            'password.request', 
            'password.reset',  
            'password.email',  
            'password.update',
            'home' 
        ];

     $isResetPage = in_array($currentRoute, $blacklistedRoutes);
    ?>

    
    <?php if(!$isResetPage && (session('status') || $errors->any() || session('login_required') || request()->get('auth') === 'login')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modalElement = document.getElementById('authModal');
                
               
                if (modalElement) {
                    const authModal = new bootstrap.Modal(modalElement);
                    const authContainer = document.querySelector(".auth-container");

                    
                    <?php if($errors->has('first_name') || $errors->has('last_name') || $errors->has('password_confirmation')): ?>
                        if (authContainer && !authContainer.classList.contains("is-flipped")) {
                            authContainer.classList.add("is-flipped");
                        }
                    <?php endif; ?>

                 
                    authModal.show();
                }
            });
        </script>
    <?php endif; ?>
<?php endif; ?>
    </body>

</html><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/partials/endbody.blade.php ENDPATH**/ ?>