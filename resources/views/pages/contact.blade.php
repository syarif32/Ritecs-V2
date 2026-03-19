@extends('layouts.main')

@section('content')

{{-- 1. Bagian Breadcrumb --}}
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contact Us</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-primary">Contact</li>
        </ol>    
    </div>
</div>

{{-- 2. Container Utama Kontak --}}
<div class="container-fluid contact bg-light py-5" id="contact">
    <div class="container py-5">
        
        {{-- Judul Halaman --}}
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Contact Us</h4>
            <h1 class="display-4 mb-4">If you have any comments please apply now</h1>
        </div>

        {{-- BARIS 1: Gambar & Formulir --}}
        <div class="row g-5 mb-5"> {{-- Tambah mb-5 untuk jarak ke bawah --}}
            {{-- Kolom Kiri: Gambar --}}
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="contact-img d-flex justify-content-center">
                    <div class="contact-img-inner">
                        <img src="{{ asset('assets/img/logo/logo.webp') }}" class="img-fluid w-75 p-5" alt="Image">
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Formulir --}}
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                <div>
                    <h4 class="text-primary">Send Your Message</h4>

                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('contact.store') }}" class="mt-4">
                        @csrf  
                        <div class="row g-3">
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}">
                                    <label for="name">Your Name</label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control border-0 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Your Email" value="{{ old('email') }}">
                                    <label for="email">Your Email</label>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}">
                                    <label for="phone">Your Phone</label>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 @error('address') is-invalid @enderror" id="address" name="address" placeholder="Your Address" value="{{ old('address') }}">
                                    <label for="address">Your Address</label>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                                    <label for="subject">Subject</label>
                                    @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control border-0 @error('message') is-invalid @enderror" placeholder="Leave a message here" id="message" name="message" style="height: 120px">{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div> {{-- Penutup ROW G-5 (Formulir Selesai Disini) --}}

        {{-- BARIS 2: Info Kontak --}}
        <div class="row g-4 mb-5"> {{-- Buat Row Baru --}}
            <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="contact-add-item">
                    <div class="contact-icon text-primary mb-4"><i class="fas fa-map-marker-alt fa-2x"></i></div>
                    <div>
                        <h4>Address</h4>
                        <p class="mb-0">{{ $address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="contact-add-item">
                    <div class="contact-icon text-primary mb-4"><i class="fas fa-envelope fa-2x"></i></div>
                    <div>
                        <h4>Mail Us</h4>
                        <p class="mb-0">{{ $email }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.6s">
                <div class="contact-add-item">
                    <div class="contact-icon text-primary mb-4"><i class="fa fa-phone-alt fa-2x"></i></div>
                    <div>
                        <h4>Telephone</h4>
                        <p class="mb-0">{{ $phone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.8s">
                <div class="contact-add-item">
                    <div class="contact-icon text-primary mb-4"><i class="fab fa-firefox-browser fa-2x"></i></div>
                    <div>
                        <h4>Site</h4>
                        <p class="mb-0">{{ $site }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS 3: Peta --}}
        <div class="row wow fadeInUp" data-wow-delay="0.2s">
            <div class="col-12">
                <div class="rounded">
                    <iframe class="rounded w-100" 
                    style="height: 400px;" src="{{ $map_link }}" 
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

    </div> {{-- Penutup Container --}}
</div> {{-- Penutup Container Fluid --}}

@endsection