@extends('backend.layouts.main')

@section('title', 'Content History Log')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">Content Publishing History</h2>
            <p class="card-text">Riwayat aktivitas unggahan Buku, Jurnal, dan Awarding oleh Admin.</p>

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-hover datatables" id="dataTable-1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Admin (Pelaku)</th>
                                        <th>Aksi</th>
                                        <th>Tipe Konten</th>
                                        <th>Deskripsi Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                    <tr>
                                        {{-- 1. Waktu --}}
                                        <td>
                                            <div class="text-dark">{{ $log->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                                        </td>

                                        {{-- 2. Admin --}}
                                        <td>
                                            @if($log->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="{{ $log->user->img_path ? asset($log->user->img_path) : asset('backend/assets/avatars/face-1.jpg') }}" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <strong class="text-dark">{{ $log->user->email }}</strong><br>
                                                        <small class="text-muted">{{ $log->user->first_name }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted font-italic">Admin Terhapus</span>
                                            @endif
                                        </td>

                                        {{-- 3. Jenis Aksi --}}
                                        <td>
                                            @if($log->action == 'CREATE')
                                                <span class="badge badge-pill badge-success">
                                                    <i class="fe fe-plus mr-1"></i> Upload
                                                </span>
                                            @elseif($log->action == 'UPDATE')
                                                <span class="badge badge-pill badge-warning text-white">
                                                    <i class="fe fe-edit mr-1"></i> Edit
                                                </span>
                                            @elseif($log->action == 'DELETE')
                                                <span class="badge badge-pill badge-danger">
                                                    <i class="fe fe-trash mr-1"></i> Hapus
                                                </span>
                                            @endif
                                        </td>

                                        {{-- 4. Tipe Konten --}}
                                        <td>
                                            @if(str_contains($log->content_type, 'Book'))
                                                <span class="badge badge-light border border-secondary text-secondary">
                                                    <i class="fas fa-book mr-1"></i> Buku
                                                </span>
                                            @elseif(str_contains($log->content_type, 'Journal'))
                                                <span class="badge badge-light border border-primary text-primary">
                                                    <i class="fas fa-newspaper mr-1"></i> Jurnal
                                                </span>
                                            @elseif(str_contains($log->content_type, 'Awarding'))
                                                <span class="badge badge-light border border-warning text-warning">
                                                    <i class="fas fa-trophy mr-1"></i> Award
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">{{ class_basename($log->content_type) }}</span>
                                            @endif
                                        </td>

                                        {{-- 5. Deskripsi --}}
                                        <td>
                                            <span class="text-dark small">{{ $log->description }}</span>
                                            <br>
                                            <small class="text-muted">ID Konten: {{ $log->content_id }}</small>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-clipboard fe-24 mb-2 d-block"></i>
                                                Belum ada riwayat publikasi.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div> 
        </div> 
    </div> 
</div> 
@endsection