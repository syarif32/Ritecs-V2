<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{ ucfirst($title ?? 'Ritecs') }} - Ritecs</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css')}}"/>
        <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/logo.webp')}}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    </head>

    <body 
    {{-- PERBAIKAN: Jangan tampilkan error login jika sedang di halaman HOME --}}
    @if(session('login_required') && !request()->routeIs('home')) 
        data-login-required="{{ session('login_required') }}" 
    @endif
    
    @if( ($errors->has('email') && old('email')) || $errors->has('first_name') ) 
        data-validation-error="true" 
    @endif
    
    @if($errors->has('first_name') || $errors->has('password'))
        data-error-is-register="true"
    @endif

    @if(session('loginError'))
        data-login-error-message="{{ session('loginError') }}"
    @endif
>

        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="container-fluid topbar px-0 px-lg-4 bg-light py-2 d-none d-lg-block">
    <div class="container">
        <div class="row gx-0 align-items-center">
            <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                <div class="d-flex flex-wrap">
                    <div class="border-end border-primary pe-3">
                        <a href="#" id="find-location-btn" class="text-muted small">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span id="location-text">{{ $footer_address->value ?? 'Find A Location' }}</span>
                        </a>
                    </div>
                    <div class="ps-3">
                        @if($footer_email)
                            <a href="mailto:{{ $footer_email->value }}" class="text-muted small">
                                <i class="fas fa-envelope text-primary me-2"></i>{{ $footer_email->value }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-flex justify-content-end">
                    <div class="d-flex border-end border-primary pe-3">
                        @if($social_facebook)
                            <a class="btn p-0 text-primary me-3" href="{{ $social_facebook->value }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($social_twitter)
                            <a class="btn p-0 text-primary me-3" href="{{ $social_twitter->value }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($social_instagram)
                            <a class="btn p-0 text-primary me-3" href="{{ $social_instagram->value }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($social_linkedin)
                            <a class="btn p-0 text-primary me-0" href="{{ $social_linkedin->value }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>