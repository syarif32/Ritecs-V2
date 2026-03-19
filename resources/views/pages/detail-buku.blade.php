@extends('layouts.main')

@section('content')

<div class="container-fluid feature bg-light pb-5 pt-3">

    <div class="container">
        <p class="normal-text">Publish > <a class="normal-text" href="{{ route('buku') }}">Buku</a> > <a class="text-dark small" href="#">{{ $book->title }}</a></p>
    </div>

    <div class="container-fluid blog py-5 bg-white">
        <div class="container pb-5">
            
            <div class="card mb-3 h-100 border-0 shadow-none">
                <div class="row g-0">
                    
                    <div class="col-md-4">
                        <div class="blog-img rounded shadow">
                            <img src="{{ asset($book->cover_path) }}" class="img-fluid w-100 object-fit-contain rounded-start rounded-end" alt="{{ $book->title }}">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body ps-md-4 ps-lg-5 ps-2 pt-lg-3 pt-4">
                            
                            <h3 class="d-inline-block mb-2">{{ $book->title }}</h3>

                            <div class="d-flex align-items-center mb-3">
                                <div class="d-flex align-items-center text-dark">
                                    <i class="bi bi-eye-fill text-primary me-2"></i> 
                                    <span>{{ number_format($book->visitor_count, 0, ',', '.') }} x dilihat</span>
                                </div>

                                <div class="mx-3 border-start border-dark" style="height: 15px; opacity: 0.2;"></div>

                                <div class="d-flex align-items-center text-dark">
                                    <i class="bi bi-cloud-arrow-down-fill text-success me-2"></i> 
                                    <span>{{ number_format($book->download_count, 0, ',', '.') }} x diunduh</span>
                                </div>
                            </div>
                            <div class="d-grid justify-content-start mb-3 flex-wrap">
                                {{-- FIXED: Tampilkan writer dengan urutan yang benar --}}
                                <div class="content my-1">
                                    <span class="bi bi-pen text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> Penulis : </span>
                                        <span>
                                            @foreach($book->writers as $writer)
                                                {{ $writer->name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    </span>
                                </div>
                                <div class="content my-1">
                                    <span class="bi bi-journal-album text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> Penerbit : </span>
                                        <span>{{ $book->publisher }}</span>
                                    </span>
                                </div>
                                <div class="content my-1">
                                    <span class="bi bi-file-earmark-text text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> Halaman : </span>
                                        <span>{{ $book->pages }} halaman</span>
                                    </span>
                                </div>
                                <div class="content my-1">
                                    <span class="bi bi-arrows-fullscreen text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> Ukuran : </span>
                                        <span>{{ $book->width }} x {{ $book->length }} cm</span>
                                    </span>
                                </div>
                                <div class="content my-1">
                                    <span class="bi bi-calendar-plus text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> Diterbitkan : </span>
                                        <span>{{ \Carbon\Carbon::parse($book->publish_date)->format('j F Y') }}</span>
                                    </span>
                                </div>
                                <div class="content my-1">
                                    <span class="bi bi-upc-scan text-dark small"></span>
                                    <span>
                                        <span class="text-dark h6 ms-1"> ISBN : </span>
                                        <span>{{ $book->isbn }}</span>
                                    </span>
                                </div>
                                
                                <div class="content my-1 d-flex">
                                    <span class="bi bi-cash-stack text-dark small"></span>
                                    <span class="text-dark h6 ms-2"> Harga : </span>
                                    <span class="d-grid d-md-flex align-items-center">
                                        @if($book->print_price)
                                        <span class="bg-warning-soft rounded-pill my-1 my-md-0 px-3 py-0 text-dark small mx-1">Rp {{ number_format($book->print_price, 0, ',', '.') }} (cetak)</span> 
                                        @endif
                                        @if($book->ebook_price)
                                        <span class="bg-secondary-soft rounded-pill my-1 my-md-0 px-3 py-0 text-dark small mx-1">Rp {{ number_format($book->ebook_price, 0, ',', '.') }} (pdf)</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="content my-1">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item p-0 border-0">
                                        <h2 class="accordion-header p-0 border-0">
                                            <button class="accordion-button bg-transparent text-dark p-0 py-2 h6 rounded-0 outline-0 border-bottom-1 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Sinopsis : 
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show p-0 border-0" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0 border-0 pt-1">
                                                {{ $book->synopsis }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content mt-4">
                                <div class="row g-2"> 
                                    <div class="col-6">
                                        <a href="{{ route('buku.download', $book->book_id) }}" target="_blank" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm" style="font-size: 0.95rem;">
                                            <i class="fas fa-download me-2"></i>Unduh E-Book
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-dark w-100 rounded-pill py-2 shadow-sm btn-login-me" style="font-size: 0.95rem;">
                                            <i class="bi bi-cart-plus-fill me-2"></i>Pemesanan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection