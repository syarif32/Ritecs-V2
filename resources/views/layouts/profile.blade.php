<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{ ucfirst($title ?? 'Ritecs') }} - Ritecs</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css') }}"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}"/>
        <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/logo.webp') }}">
        <link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('backend/css/loader.css') }}">
    
    </head>

    <body class="bg-light">

        <!-- Loader -->
        <div id="loader">
            <div class="spinner-with-bg">
                <div class="spinner-circle"></div>
                <img src="{{ asset('assets/img/logo/logo.webp')}}" alt="Logo" class="loader-logo">
            </div>
        </div>
        
        <!-- Navbar untuk Mobile -->
        <nav class="navbar navbar-light bg-white border-bottom d-md-none">
            <div class="container px-4">
                <div class="text-center d-flex align-items-center h-100">
                    <img src="{{ asset('assets/img/logo/logo-text.webp') }}" alt="Logo Ritecs" class="img-fluid sidebar-logo">
                </div>
                <button class="btn btn-dark btn-login-me" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                    <i class="bi bi-list"></i>
                </button>    
            </div>
        </nav>

        <div class="container mt-4">
            <div class="w-100 text-start align-items-center justify-content-between pe-3 d-none d-md-flex">
                <img src="{{ asset('assets/img/logo/logo-text.webp') }}" alt="Logo Ritecs" class="img-fluid sidebar-logo">
                <span class="small p-0 m-0">Riset dan Inovasi pada Teknologi Computer Science</span>
            </div>
            <div class="row">
                <!-- Sidebar Desktop -->
                <div class="col-md-3 col-xl-2 d-none d-md-block sidebar bg-white mt-3 mb-5 rounded shadow-sm border-top border-primary border-5">
                    <div class="sidebar-sticky pb-3">
                        <!-- <div class="text-center mb-2">
                            <img src="{{ asset('assets/img/logo/logo-text.webp') }}" alt="Logo Ritecs" class="img-fluid sidebar-logo">
                        </div> -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('home') }}">
                                    <i class="bi bi-house-up me-2"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a aria-disabled="true" class="nav-link disabled d-none {{ ($title ?? '') === 'Dashboard' ? 'active' : '' }}" href="{{ route('profile.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($title ?? '') === 'Settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                                    <i class="bi bi-gear me-2"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($title ?? '') === 'Membership' ? 'active' : '' }}" href="{{ route('profile.member') }}">
                                    <i class="bi bi-people me-2"></i> Membership
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout.get') }}" onclick="return confirm('Konfirmasi untuk logout. Lanjurkan?')">
                                    <i class="bi bi-door-open me-2"></i>LogOut
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>

                <!-- Sidebar Offcanvas Mobile -->
                <div class="offcanvas offcanvas-start d-md-none " tabindex="-1" id="sidebarOffcanvas">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-up me-2"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a aria-disabled="true" class="nav-link disabled d-none {{ ($title ?? '') === 'Dashboard' ? 'active' : '' }}" href="{{ route('profile.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($title ?? '') === 'Settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                                    <i class="bi bi-gear me-2"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($title ?? '') === 'Membership' ? 'active' : '' }}" href="{{ route('profile.member') }}">
                                    <i class="bi bi-people me-2"></i> Membership
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout.get') }}" onclick="return confirm('Konfirmasi untuk logout. Lanjurkan?')">
                                    <i class="bi bi-door-open me-2"></i> LogOut
                                </a>
                            </li>

                            
                        </ul>
                    </div>
                </div>

                <!-- Konten -->
                <main class="col-md-9 col-xl-10 ms-sm-auto px-md-4 pt-3 mb-5">
                    <div class="container-md bg-white p-4 rounded shadow-sm container-main border border-5 border-bottom-0 border-start-0 border-end-0 border-primary">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Canvg UMD yang bekerja di browser -->
        <script src="https://cdn.jsdelivr.net/npm/canvg@3.0.10/lib/umd.min.js"></script>




        <!-- Template Javascript -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>
            window.addEventListener("load", function() {
                document.getElementById("loader").style.display = "none";
            });
        </script>
    </body>

</html>