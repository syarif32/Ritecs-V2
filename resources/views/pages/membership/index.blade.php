@extends('layouts.main')

@section('content')
<div class="container-fluid feature bg-white py-5">
    <div class="container py-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-4 fw-bold mb-4">Direktori Anggota RITECS</h1>
        </div>
        <div class="col-lg-10 col-xl-8 mx-auto wow fadeInUp" data-wow-delay="0.3s">
            <p class="fs-5 text-muted text-center">
                Jelajahi direktori anggota kami untuk terhubung dengan para profesional dan peneliti di bidang ilmu komputer. Gunakan fitur pencarian untuk menemukan anggota berdasarkan nama atau nomor keanggotaan.
            </p>
        </div>
        
        {{-- Search Bar --}}
        <div class="container pb-5 my-5">
            <div class="col-lg-8 mx-auto wow fadeInUp" data-wow-delay="0.5s">
                <form id="searchForm" action="{{ route('membership.index') }}" method="GET">
                    {{-- Hidden inputs to preserve filters and sorting on new search --}}
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="search" name="search" class="form-control border-end-0"
                            placeholder="Cari nama anggota atau kode member..." aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row g-5">
                {{-- Sidebar for Filters --}}
                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 2rem;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">Filter Status</h5>
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('membership.index', ['search' => request('search'), 'sort' => request('sort')]) }}"
                                       class="list-group-item list-group-item-action py-2 my-1 small rounded-3 {{ !request('status') ? 'active' : '' }}">
                                        <i class="fas fa-users me-2"></i> Semua Status
                                    </a>
                                    <a href="{{ route('membership.index', ['status' => 'active', 'search' => request('search'), 'sort' => request('sort')]) }}"
                                       class="list-group-item list-group-item-action py-2 my-1 small rounded-3 {{ request('status') == 'active' ? 'active' : '' }}">
                                        <i class="fas fa-check-circle me-2 text-success"></i> Aktif
                                    </a>
                                    <a href="{{ route('membership.index', ['status' => 'expired', 'search' => request('search'), 'sort' => request('sort')]) }}"
                                       class="list-group-item list-group-item-action py-2 my-1 small rounded-3 {{ request('status') == 'expired' ? 'active' : '' }}">
                                        <i class="fas fa-times-circle me-2 text-danger"></i> Non Aktif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Content: Member List --}}
                <div class="col-lg-8">
                    {{-- Header with result count and sorting --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <div class="text-muted small">Menampilkan {{ $memberships->firstItem() ?? 0 }}-{{ $memberships->lastItem() ?? 0 }} dari {{ $memberships->total() }} hasil</div>
                        <div>
                            <form id="sortForm" action="{{ route('membership.index') }}" method="GET" class="d-flex align-items-center">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <label for="sortBy" class="form-label me-2 mb-0 small text-muted">Urutkan:</label>
                                <select class="form-select form-select-sm" id="sortBy" name="sort" onchange="this.form.submit()" style="width: auto;">
                                    <option value="name_asc" {{ request('sort', 'name_asc') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Member Cards Grid --}}
                    <div class="row g-4">
                        @forelse ($memberships as $membership)
                        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <div class="card-body p-4 text-center">
                                    
                                    <div class="mb-3">
                                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                                    </div>

                                    {{-- NAMA MEMBER (Logic User vs Guest) --}}
                                    <h5 class="card-title mb-1 text-truncate" title="{{ $membership->user ? $membership->user->first_name . ' ' . $membership->user->last_name : $membership->guest_first_name . ' ' . $membership->guest_last_name }}">
                                        @if($membership->user)
                                            {{-- Tampilkan nama dari tabel Users --}}
                                            {{ $membership->user->first_name }} {{ $membership->user->last_name }}
                                        @else
                                            {{-- Tampilkan nama dari tabel Memberships (Guest) --}}
                                            {{ $membership->guest_first_name }} {{ $membership->guest_last_name }}
                                        @endif
                                    </h5>

                                    {{-- NOMOR ANGGOTA --}}
                                    <p class="text-muted small mb-3">
                                        ID: {{ $membership->member_number }}
                                        {{-- Optional: Tampilkan Institusi jika Guest --}}
                                        @if(!$membership->user && $membership->guest_institution)
                                            <br><span class="fst-italic">{{ $membership->guest_institution }}</span>
                                        @endif
                                    </p>

                                    {{-- STATUS BADGE --}}
                                    <span class="badge {{ $membership->status == 1 ? 'bg-success text-white' : 'bg-secondary text-white' }} rounded-pill px-3 py-2">
                                        <i class="fas {{ $membership->status == 1 ? 'fa-check-circle me-1' : 'fa-times-circle me-1' }}"></i>
                                        {{ $membership->status == 1 ? 'Aktif' : 'Non Aktif' }}
                                    </span>

                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <p class="text-muted fs-5">Anggota tidak ditemukan.</p>
                            <p class="text-muted">Coba ubah kata kunci pencarian atau filter Anda.</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Pagination Links (RAPI & DI TENGAH) --}}
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $memberships->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection