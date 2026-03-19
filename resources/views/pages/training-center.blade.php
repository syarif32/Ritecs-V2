@extends('layouts.main')

@section('content')

<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Training Center</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-primary">Training Center</li>
        </ol>    
    </div>
</div>
<div class="container-fluid feature bg-light py-5" id="training">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Program Pelatihan</h4>
            <h1 class="display-4 mb-4">Tingkatkan Kompetensi Anda Bersama Kami</h1>
            <p class="mb-0">Kami menyelenggarakan berbagai program pelatihan dan workshop yang dirancang untuk meningkatkan keahlian Anda di bidang penulisan, publikasi ilmiah, dan kekayaan intelektual.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($trainings as $training)
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card h-100 p-4 pt-0 border-0 shadow-sm">
                    <img src="{{ asset('storage/' . $training->image_path) }}" class="card-img-top rounded mt-4" alt="{{ $training->title }}">
                    <div class="card-body p-0 pt-4 d-flex flex-column">
                        <h5 class="card-title text-dark mb-3">{{ $training->title }}</h5>
                        <p class="card-text text-muted mb-4">{{ Str::limit($training->description, 100) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                <span>Jadwal: {{ $training->schedule }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                <span>Narahubung: {{ $training->contact_person }}</span>
                            </div>
                            <h6 class="text-dark mb-1">Investasi:</h6>
                            <p class="text-primary fw-bold fs-5 mb-0">{{ $training->price }} <span class="fw-normal fs-6 text-muted">{{ $training->price_period }}</span></p>
                            <small class="text-muted d-block mb-3">{{ $training->price_note }}</small>
                            <button class="btn btn-outline-primary rounded-pill py-2 px-4" data-bs-toggle="modal"
                                        data-bs-target="#trainingModal{{ $training->id }}">
                                        Selengkapnya
                                    </button>
                            <a href="{{ $training->button_url }}" class="btn btn-primary rounded-pill py-2 px-4" target="_blank">{{ $training->button_text }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Program pelatihan akan segera diumumkan.</p>
            @endforelse
        </div>
    </div>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="h-100">
                   <h4 class="text-primary">{{ $haki_title->value ?? 'Kekayaan Intelektual' }}</h4>
                   <h1 class="display-4 mb-4">{{ $haki_subtitle->value ?? 'Lindungi Karya Anda dengan Layanan HAKI' }}</h1>
                   <p class="mb-4">{{ $haki_description->value ?? 'Deskripsi HAKI belum diatur.' }}</p>
                    
                    @forelse($haki_services as $service)
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-lg-square rounded-circle bg-light">
                            <i class="{{ $service->icon }} text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark">{{ $service->title }}</h5>
                            <p class="mb-0 text-muted">{{ $service->description }}</p>
                        </div>
                    </div>
                    @empty
                    <p>Layanan HAKI akan segera diumumkan.</p>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <div class="p-4 bg-light rounded">
                    <img src="{{ asset('storage/' . ($haki_image->value ?? '')) }}" class="img-fluid w-100 rounded" alt="HAKI Image">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade training-modal" id="trainingModal{{ $training->id }}" tabindex="-1" aria-labelledby="trainingModalLabel{{ $training->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content training-card">
            <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-image-container">
                <img src="{{ asset('storage/' . $training->image_path) }}" alt="{{ $training->title }}">
            </div>
            <div class="modal-title-box text-center p-3">
                <h2 class="fw-bold mb-0">{{ $training->title }}</h2>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted">{{ $training->description }}</p>

                <div class="detail-grid mt-4">
                    <div class="detail-box">
                        <i class="fas fa-calendar-alt text-primary"></i>
                        <div>
                            <strong>Jadwal</strong>
                            <p class="mb-0">{{ $training->schedule }}</p>
                        </div>
                    </div>
                    <div class="detail-box">
                        <i class="fas fa-user-tie text-primary"></i>
                        <div>
                            <strong>Narahubung</strong>
                            <p class="mb-0">{{ $training->contact_person }}</p>
                        </div>
                    </div>
                </div>
                <div class="price-card mt-4">
                    <strong class="d-block mb-2">Investasi:</strong>
                    <span class="price-amount">{{ $training->price }}</span>
                    <span class="price-period">{{ $training->price_period }}</span>
                    @if($training->price_note)
                        <small class="d-block mt-2">{{ $training->price_note }}</small>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ $training->button_url }}" target="_blank" class="btn btn-primary btn-lg rounded-pill w-100 shadow-sm">
                    {{ $training->button_text }}
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
    
/* modal training  */

.training-modal .modal-dialog {
    max-width: 650px;   
    width: 90%;
}


.training-modal .training-card {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    background: #fff;
}

.training-modal .btn-close-custom {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 20;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    padding: 0.5rem;
    transition: all 0.2s ease;
}
.training-modal .btn-close-custom:hover {
    transform: rotate(90deg);
    background: #fff;
}
.training-modal .modal-image-container {
    width: 100%;
    background: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}
.training-modal .modal-image-container img {
    width: 100%;
    max-height: 280px;
    object-fit: contain; 
    border-radius: 0.75rem;
}


.training-modal .modal-title-box h2 {
    font-size: 1.6rem;
    color: #333;
}


.training-modal .modal-body {
    font-size: 0.95rem;
    color: #555;
}


.training-modal .detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.training-modal .detail-box {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e9ecef;
    transition: transform 0.2s ease;
}
.training-modal .detail-box:hover {
    transform: translateY(-2px);
}
.training-modal .detail-box i {
    font-size: 1.5rem;
}


.training-modal .price-card {
    background: #f0f4ff;
    text-align: center;
    padding: 1.5rem;
    border-radius: 0.75rem;
}
.training-modal .price-card .price-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--bs-primary);
}
.training-modal .price-card .price-period {
    display: block;
    font-size: 1rem;
    color: #6c757d;
}
.training-modal .price-card small {
    color: #6c757d;
    font-style: italic;
}

.training-modal .modal-footer {
    padding: 1rem 1.5rem;
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
}
.training-modal .modal-footer .btn {
    font-size: 1.05rem;
    font-weight: 600;
    padding: 0.75rem;
    transition: all 0.2s ease;
}
.training-modal .modal-footer .btn:hover {
    transform: translateY(-2px);
}


/* end modal training  */
</style>
@endsection