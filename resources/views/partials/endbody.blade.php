<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>
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

@auth
    
    <form id="logout-form-trigger" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @if(session('activation_success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Permintaan Terkirim!',
                    text: "{{ session('activation_success') }}",
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
    @endif
@endauth
@guest
    @php
       
        $currentRoute = request()->route() ? request()->route()->getName() : '';
        
        
        $blacklistedRoutes = [
            'password.request', 
            'password.reset',  
            'password.email',  
            'password.update',
            'home' 
        ];

     $isResetPage = in_array($currentRoute, $blacklistedRoutes);
    @endphp

    
    @if (!$isResetPage && (session('status') || $errors->any() || session('login_required') || request()->get('auth') === 'login'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modalElement = document.getElementById('authModal');
                
               
                if (modalElement) {
                    const authModal = new bootstrap.Modal(modalElement);
                    const authContainer = document.querySelector(".auth-container");

                    
                    @if ($errors->has('first_name') || $errors->has('last_name') || $errors->has('password_confirmation'))
                        if (authContainer && !authContainer.classList.contains("is-flipped")) {
                            authContainer.classList.add("is-flipped");
                        }
                    @endif

                 
                    authModal.show();
                }
            });
        </script>
    @endif
@endguest
    </body>

</html>