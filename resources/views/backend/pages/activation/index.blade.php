@extends('backend.layouts.main')

@section('title', 'Permintaan Aktivasi Manual')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            {{-- Header Halaman --}}
            <h2 class="mb-2 page-title">Permintaan Aktivasi Manual</h2>
            <p class="card-text">Daftar pengguna yang mengalami kendala verifikasi OTP. Tindakan Anda akan memverifikasi email mereka secara manual.</p>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="fe fe-check-circle fe-16 mr-2"></span> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="fe fe-alert-triangle fe-16 mr-2"></span> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            
                            {{-- Logic Jika Data Kosong --}}
                            @if($requests->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle bg-light text-success">
                                                <i class="fe fe-check-circle fe-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="text-muted">Semua Aman!</h4>
                                    <p class="text-secondary">Tidak ada permintaan aktivasi yang tertunda saat ini.</p>
                                </div>
                            @else
                                {{-- Tabel Data --}}
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pengguna</th>
                                            <th>Masalah / Alasan</th>
                                            <th>Waktu Request</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests as $req)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div>
                                                        <p class="mb-0 text-muted"><strong>{{ $req->user->first_name }} {{ $req->user->last_name }}</strong></p>
                                                        <small class="mb-0 text-muted">{{ $req->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-danger font-italic">"{{ $req->reason }}"</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $req->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td class="text-right">
                                                {{-- Tombol Trigger Modal Approve --}}
                                                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#approveModal-{{ $req->id }}">
                                                    <i class="fe fe-check fe-12 mr-1"></i> Terima
                                                </button>

                                                {{-- Tombol Trigger Modal Reject --}}
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#rejectModal-{{ $req->id }}">
                                                    <i class="fe fe-x fe-12 mr-1"></i> Tolak
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- ================= MODAL APPROVE ================= --}}
                                        <div class="modal fade" id="approveModal-{{ $req->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success">
                                                            <i class="fe fe-check-circle mr-2"></i>Setujui Aktivasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.activation.approve', $req->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin <strong>mengaktifkan</strong> akun pengguna ini secara manual?</p>
                                                            
                                                            {{-- Kartu Info User --}}
                                                            <div class="card bg-light border-0 mb-3">
                                                                <div class="card-body p-2 d-flex align-items-center">
                                                                   
                                                                    <div>
                                                                        <div class="font-weight-bold">{{ $req->user->first_name }} {{ $req->user->last_name }}</div>
                                                                        <small>{{ $req->user->email }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="alert alert-warning small">
                                                                <i class="fe fe-info mr-1"></i> Status email user akan berubah menjadi <strong>Verified</strong> dan user dapat langsung login.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Ya, Aktifkan User</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================= MODAL REJECT ================= --}}
                                        <div class="modal fade" id="rejectModal-{{ $req->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger">
                                                            <i class="fe fe-x-circle mr-2"></i>Tolak Permintaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.activation.reject', $req->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <p>Anda akan menolak permintaan aktivasi untuk:</p>
                                                            
                                                           
                                                            <div class="card bg-light border-0 mb-3">
                                                                <div class="card-body p-2 d-flex align-items-center">
                                                                    <div class="avatar avatar-sm mr-3">
                                                                        <img src="{{ $req->user->img_path ? asset($req->user->img_path) : asset('backend/assets/avatars/face-1.jpg') }}" class="avatar-img rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-weight-bold">{{ $req->user->first_name }} {{ $req->user->last_name }}</div>
                                                                        <small class="text-muted">{{ $req->reason }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <p class="text-muted small">Permintaan ini akan ditandai sebagai 'Rejected' dan user tetap tidak bisa login.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div> 
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</div>
@endsection