
@extends('layouts.main')

@section('content')

    <div class="container-fluid feature bg-white py-5">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="display-4 fw-bold mb-4">RITECS Open Journal System</h1>
            </div>
            <div class="col-lg-10 col-xl-8 mx-auto wow fadeInUp" data-wow-delay="0.3s">
                <p class="fs-5 text-muted text-start">
                    Portal penerbitan jurnal ilmiah RITECS yang memfasilitasi publikasi penelitian dari berbagai disiplin
                    ilmu dengan sistem akses terbuka, proses peninjauan sejawat yang ketat, dan kualitas terjamin.</p>
            </div>
            <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.5s">
                <a href="https://ritecs.org/journal/" target="_blank" class="btn btn-primary btn-lg rounded-pill py-3 px-5">
                    <i class="fas fa-external-link-alt me-2"></i> Kunjungi Portal OJS
                </a>
            </div>
        </div>
        <div class="container pb-5 mb-5">
            <div class="col-lg-8 mx-auto wow fadeInUp" data-wow-delay="0.7s">
               
                <form action="{{ route('journal') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="search" name="search" class="form-control border-end-0"
                            placeholder="Cari jurnal atau kata kunci..." aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container blog py-3">
            <div class="row">
                <div class="col-lg-8">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <div class="text-muted">Menampilkan {{ $journals->firstItem() ?? 0 }}-{{ $journals->lastItem() ?? 0 }} dari {{ $journals->total() }} hasil</div>
                            <div class="d-flex align-items-center">
                                <label for="sortBy" class="form-label me-2 mb-0 small text-muted">Urutkan:</label>
                               
                                <select class="form-select form-select-sm" id="sortBy" name="sort" style="width: auto;">
                                    <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 justify-content-start text-start">
                             
                            @forelse ($journals as $journal)
                            <div class="col-md-6 col-xxl-4 wow fadeInUp" data-wow-delay="0.6s">
                                <div class="blog-item rounded">
                                    <div class="blog-img rounded-top">
                                        <img src="{{ asset($journal->cover_path) }}" class="img-fluid rounded-top w-100" alt="{{ $journal->title }}">
                                    </div>
                                    <div class="blog-content h-100 rounded p-3 d-grid align-content-between">
                                        <div class="card-body p-0 m-0">
                                            <a href="{{ $journal->url_path }}" target="_blank" class="h6 d-inline-block mb-2">{{ Str::limit($journal->title, 55) }}</a>
                                            @if ($journal->keywords->isNotEmpty())
                                            <div class="kata-kunci my-1">
                                                <p class="h6 small mb-0 ">Kata Kunci : </p>
                                                @foreach ($journal->keywords as $keyword)
                                                    <span class="keywords-badge py-0 small my-1 ms-0 me-1">{{ $keyword->name }}</span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                        <a href="{{ $journal->url_path }}" target="_blank" class="p-0 text-dark small position-relative bottom-0">Detail jurnal<i class="fa fa-arrow-right ms-2 small"></i></a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center">
                                <p class="text-muted fs-5">Jurnal tidak ditemukan.</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="mt-5">
                            {{ $journals->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 2rem;">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="card-title mb-3 h5">Filter Kata Kunci</p>
                                <div class="list-group list-group-flush subject-list">
                                    <a href="{{ route('journal', ['search' => request('search'), 'sort' => request('sort')]) }}"
                                       class="list-group-item list-group-item-action py-1 my-1 small {{ !request('keyword') ? 'active' : '' }}">
                                        <i class="fas fa-star me-2"></i> Semua Kata Kunci
                                    </a>
                                    @foreach ($keywords as $keyword)
                                    <a href="{{ route('journal', ['keyword' => $keyword->name, 'search' => request('search'), 'sort' => request('sort')]) }}"
                                       class="list-group-item list-group-item-action py-1 my-1 small {{ request('keyword') == $keyword->name ? 'active' : '' }}">
                                        {{ $keyword->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
