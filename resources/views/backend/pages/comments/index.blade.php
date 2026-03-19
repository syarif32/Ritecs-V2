@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Data Komentar & Aduan</h2>
      <div class="card shadow">
        <div class="card-body">
          
          {{-- Alert Messages --}}
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table datatables table-hover" id="dataTable-1">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Subjek</th> {{-- Ditambahkan --}}
                    <th>Email</th>
                    <th width="20%">Pesan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-weight-bold">{{ $comment->name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($comment->subject ?? '-', 20) }}</td> {{-- Ditambahkan --}}
                        <td>{{ $comment->email }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($comment->message, 40) }}</td>
                        <td>
                            @if($comment->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                            @elseif($comment->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-danger">Spam</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    id="action-{{$comment->id}}" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="action-{{$comment->id}}">
                                    
                                    {{-- Tombol Detail Utama --}}
                                    <a class="dropdown-item font-weight-bold text-primary" href="{{ route('admin.comments.edit', $comment->id) }}">
                                        <i class="fe fe-eye mr-2"></i> Lihat & Balas
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>

                                    @if($comment->status != 'approved')
                                    <form action="{{ route('admin.comments.updateStatus', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="dropdown-item"><i class="fe fe-check mr-2"></i> Approve</button>
                                    </form>
                                    @endif

                                    @if($comment->status != 'spam')
                                    <form action="{{ route('admin.comments.updateStatus', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="spam">
                                        <button type="submit" class="dropdown-item"><i class="fe fe-slash mr-2"></i> Tandai Spam</button>
                                    </form>
                                    @endif

                                    <div class="dropdown-divider"></div>
                                
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fe fe-trash-2 mr-2"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection