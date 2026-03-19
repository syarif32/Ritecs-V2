@extends('layouts.main')

@section('content')

    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.2s">Petunjuk Penulis</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Bantuan</a></li>
                <li class="breadcrumb-item active text-primary">Petunjuk Penulis</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid feature bg-light py-5">
        <div class="container-fluid py-5" id="petunjuk-penulis">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h1 class="display-6 mb-3">{{ $book_types_title->value ?? 'Menerbitkan Buku Bersama Ritecs' }}</h1>
                    <p>{{ $book_types_subtitle->value ?? 'Kami menerima beragam jenis naskah...' }}</p>
                </div>
                <div class="row g-4 justify-content-center">
                    @forelse($book_types as $book_type)
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                            <a href="#" class="text-decoration-none">
                                <div class="book-type-card">
                                    <div class="icon-container"><i class="{{ $book_type->icon }}"></i></div>
                                    <h6 class="book-title">{{ $book_type->name }}</h6>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-center">Jenis buku belum diatur.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h4 class="text-primary">Model Publikasi</h4>
                <h1 class="display-6 mb-4">{{ $schemes_title->value ?? 'Skema Penerbitan Buku' }}</h1>
                <p>{{ $schemes_subtitle->value ?? 'Pilih skema penerbitan yang paling sesuai...' }}</p>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($publishing_schemes as $scheme)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="scheme-card">
                            <div class="icon-container"><i class="{{ $scheme->icon }}"></i></div>
                            <h5 class="fw-bold text-dark mt-0">{{ $scheme->title }}</h5>
                            <p class="mb-2">{{ $scheme->description }}</p>
                            <div class="text-primary fw-medium"><i class="fas fa-check-circle me-1"></i> {{ $scheme->feature }}</div>
                        </div>
                    </div>
                @empty
                     <p class="text-center">Skema penerbitan belum diatur.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-md-5 pb-3 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Langkah & Tahap</h4>
                <h1 class="display-4 mb-4">{{ $steps_title->value ?? 'Prosedur Penerbitan Buku' }}</h1>
                <p class="mb-0">{{ $steps_subtitle->value ?? 'Ikuti prosedur berikut...' }}</p>
            </div>
            <div class="row">
                <div class="col col-12 col-xl-5 p-0 d-none d-xl-block wow fadeInUp" data-wow-delay="0.2s">
                    <div class="d-flex justify-content-center align-items-center h-100 p-3 p-md-5 ps-3 ps-md-0 pb-3 pb-md-0">
                        <img src="{{ asset('assets/img/petunjuk2.webp') }}" class="img-fluid img-petunjuk" alt="">
                    </div>
                </div>
                <div class="col col-12 col-xl-7">
                    <div class="timeline">
                        @forelse($publishing_steps as $step)
                            <div class="timeline-item wow fadeInUp" data-wow-delay="0.2s">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content rounded">
                                    <h5 class="m-0 p-0 mb-1">{{ $step->title }}</h5>
                                    <p class="p-0 m-0">{!! nl2br(e($step->description)) !!}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Prosedur penerbitan belum diatur.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection