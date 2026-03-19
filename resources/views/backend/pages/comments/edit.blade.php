@extends('backend.layouts.main')

@section('title', $title)

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Detail & Balas Pesan</h2>
                
                <div class="mb-4 mt-3">
                    @if($comment->status == 'pending')
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-alert-triangle fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Pending (Menunggu)</h5>
                                <small>Pesan ini belum ditayangkan. Silakan balas atau ubah statusnya.</small>
                            </div>
                        </div>
                    @elseif($comment->status == 'approved')
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-check-circle fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Approved (Terbalas)</h5>
                                <small>Pesan ini sudah terbalas ke email user</small>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-slash fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Spam</h5>
                                <small>Pesan ini terindikasi spam.</small>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">ID Pesan: #{{ $comment->id }}</strong>
                        <span class="badge badge-{{ $comment->status == 'approved' ? 'success' : ($comment->status == 'spam' ? 'danger' : 'warning') }}">
                            Status: {{ ucfirst($comment->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        {{-- Baris 1: Nama & Email --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Pengirim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light" value="{{ $comment->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Pengirim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-mail"></i></span>
                                        </div>
                                        <input type="email" class="form-control bg-light" value="{{ $comment->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Baris 2: Telepon & Subjek (BARU DITAMBAHKAN) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nomor Telepon / WA</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-phone"></i></span>
                                        </div>
                                        {{-- Mengambil data phone --}}
                                        <input type="text" class="form-control bg-light" value="{{ $comment->phone ?? '-' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Subjek Pesan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-tag"></i></span>
                                        </div>
                                        {{-- Mengambil data subject --}}
                                        <input type="text" class="form-control bg-light" value="{{ $comment->subject ?? 'Tidak ada subjek' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="font-weight-bold">Isi Pesan / Aduan</label>
                            <textarea class="form-control bg-light" rows="5" readonly>{{ $comment->message }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Kolom Kiri: Form Balasan --}}
                    <div class="col-md-7">
                        <div class="card shadow mb-4 border-left-primary">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fe fe-mail mr-2"></i>Balas Pesan via Email</h5>
                                <p class="text-muted small">Balasan akan dikirim ke <strong>{{ $comment->email }}</strong>. Status otomatis menjadi <strong>Approved</strong>.</p>
                                
                                <form action="{{ route('admin.comments.reply', $comment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="reply_message">Isi Balasan Anda</label>
                                        <textarea name="reply_message" id="reply_message" class="form-control" rows="5" placeholder="Yth. {{ $comment->name }}, terimakasih atas pesan Anda..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fe fe-send mr-1"></i> Kirim Balasan & Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Moderasi Manual --}}
                    <div class="col-md-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Moderasi Manual</h5>
                                <p class="text-muted small">Ubah status tanpa mengirim email balasan.</p>
                                
                                <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="status">Ubah Status</label>
                                        <select id="status" name="status" class="form-control custom-select">
                                            <option value="pending" {{ $comment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $comment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="spam" {{ $comment->status == 'spam' ? 'selected' : '' }}>Spam</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-block">Simpan Status Saja</button>
                                </form>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary btn-block mt-3">
                            <i class="fe fe-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection