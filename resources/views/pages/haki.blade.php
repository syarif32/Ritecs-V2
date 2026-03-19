@extends('layouts.main')

@section('content')


<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Layanan HAKI</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layanan</a></li>
            <li class="breadcrumb-item active text-primary">HAKI</li>
        </ol>    
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">{{ $haki_intro_title->value ?? 'Tentang HAKI' }}</h4>
            <h1 class="display-4 mb-4">{{ $haki_intro_subtitle->value ?? 'Pentingnya Hak Atas Kekayaan Intelektual' }}</h1>
            <p class="lead text-muted px-3">{{ $haki_intro_description->value ?? 'Deskripsi HAKI belum diatur.' }}</p>
        </div>
    </div>
</div>

<div class="container-fluid feature bg-light py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Cakupan Layanan</h4>
            <h1 class="display-5 mb-4">Jenis Kekayaan Intelektual yang Kami Tangani</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($haki_types as $type)
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="book-type-card h-100">
                    <div class="icon-container"><i class="{{ $type->icon }}"></i></div>
                    <h5 class="book-title">{{ $type->name }}</h5>
                </div>
            </div>
            @empty
            <p class="text-center">Jenis layanan HAKI akan segera diumumkan.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Investasi Layanan</h4>
            <h1 class="display-4 mb-5">Paket Layanan HAKI</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($haki_packages as $package)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="pricing-card h-100" style="box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header text-center"><h4 class="card-title text-dark">{{ $package->title }}</h4></div>
                    <div class="card-body text-center p-4">
                        <div class="price-tag mb-4">
                            @if($package->old_price)
                            <s class="text-muted fs-5">Rp. {{ number_format($package->old_price, 0, ',', '.') }}</s>
                            @endif
                            <h2 class="display-5 fw-bold text-primary mb-0">Rp. {{ number_format($package->new_price, 0, ',', '.') }}</h2>
                        </div>
                        @if($package->description)
                        <p class="text-muted px-3">{{ $package->description }}</p>
                        @endif
                        @if(!empty($package->features))
                        <ul class="list-group list-group-flush text-start mb-4">
                            @foreach($package->features as $feature)
                            <li class="list-group-item"><i class="fa fa-check text-primary me-2"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-4">
                        <a href="https://wa.me/6281390920585?text={{ urlencode($package->whatsapp_message) }}" class="btn btn-success rounded-pill py-2 px-4 w-100" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Paket layanan HAKI akan segera diumumkan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection