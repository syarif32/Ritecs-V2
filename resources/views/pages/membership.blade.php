@extends('layouts.main')

@section('content')

{{-- ... Header ... --}}
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Program Keanggotaan</h1>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layanan</a></li>
            <li class="breadcrumb-item active text-primary">Membership</li>
        </ol>    
    </div>
</div>

{{-- card membership --}}
<div class="container-fluid bg-light py-5" id="membership">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Pilih Paket yang Tepat Untuk Anda</h2>
            <p class="lead text-muted">Kami menawarkan berbagai level keanggotaan dengan benefit eksklusif untuk mendukung kebutuhan Anda. Bergabunglah dengan komunitas kami sekarang.</p>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="pricing-card popular h-100">
                    <div class="card-header text-center"><h4 class="card-title">Membership</h4></div>
                    <div class="card-body text-center">
                        <div class="price-tag">
                            <sup>Rp</sup><span class="display-4">{{ $price }}</span><span class="text-muted">/Tahun</span>
                        </div>
                        <p class="mt-2">{{ $price_description }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($featured_benefits as $benefit)
                            <li class="list-group-item"><i class="fas fa-check-circle me-2"></i>{{ $benefit->title }}</li>
                        @empty
                            <li class="list-group-item">Keuntungan utama belum diatur.</li>
                        @endforelse
                    </ul>
                    <div class="card-footer text-center">
                        <a href="{{route('profile.member') }}" class="btn btn-primary rounded-pill w-100">Pilih Paket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- benefits --}}
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Keuntungan Menjadi Anggota</h2>
            <p class="lead text-muted">Dapatkan akses ke sumber daya berkualitas yang akan meningkatkan pengetahuan dan keahlian Anda secara signifikan.</p>
        </div>
        <div class="row g-4">
            @forelse($benefits as $benefit)
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="{{ $benefit->icon }} fa-2x"></i></div>
                        <h5 class="mb-2">{{ $benefit->title }}</h5>
                        <p class="text-muted">{{ $benefit->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center">Keuntungan menjadi anggota akan segera diumumkan.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- faq --}}
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Pertanyaan Umum</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion skema-accordion wow fadeInUp" data-wow-delay="0.3s" id="faqAccordion">
                    @forelse($faqs as $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading{{ $loop->iteration }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $loop->iteration }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="faqCollapse{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada pertanyaan umum yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container py-5">
        <div class="text-center bg-primary rounded-3 p-5 wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="text-white display-5 mb-3">Siap Bergabung?</h2>
            <p class="text-white-50 mb-4">Tingkatkan keahlian Anda ke level berikutnya. Daftar sekarang dan nikmati semua benefit eksklusif yang kami tawarkan.</p>
            <a href="" class="btn btn-dark btn-login-me rounded-pill px-5 py-3">Daftar Sekarang</a>
        </div>
    </div>
</div>

@endsection