@extends('backend.layouts.main')

@section('title', 'History Log')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">History Log</h2>
            <p class="card-text">Catatan riwayat aktivitas promosi dan demosi administrator.</p>

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-hover datatables" id="dataTable-1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Waktu Kejadian</th>
                                        <th>Admin (Pelaku)</th>
                                        <th>Jenis Aksi</th>
                                        <th>Target User</th>
                                        <th>Keterangan</th>
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

                                        {{-- 2. Actor (Admin) --}}
                                        <td>
                                            @if($log->actor)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="{{ $log->actor->img_path ? asset($log->actor->img_path) : asset('backend/assets/images/user.svg') }}" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <strong class="text-dark">{{ $log->actor->email }}</strong>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted font-italic">(User Terhapus)</span>
                                            @endif
                                        </td>

                                        {{-- 3. Jenis Aksi --}}
                                        <td>
                                            @if($log->action_type == 'PROMOTE')
                                                <span class="badge badge-pill badge-success">
                                                    <i class="fe fe-arrow-up mr-1"></i> Promote
                                                </span>
                                            @elseif($log->action_type == 'DEMOTE')
                                                <span class="badge badge-pill badge-danger">
                                                    <i class="fe fe-arrow-down mr-1"></i> Demote
                                                </span>
                                            @else
                                                <span class="badge badge-pill badge-secondary">{{ $log->action_type }}</span>
                                            @endif
                                        </td>

                                        {{-- 4. Target User --}}
                                        <td>
                                            @if($log->target)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="{{ $log->target->img_path ? asset($log->target->img_path) : asset('backend/assets/images/user.svg') }}" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <span>{{ $log->target->first_name }} {{ $log->target->last_name }}</span><br>
                                                        <small class="text-muted">{{ $log->target->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted font-italic">User ID: {{ $log->target_id }} (Terhapus)</span>
                                            @endif
                                        </td>

                                        {{-- 5. Deskripsi --}}
                                        <td>
                                            <span class="text-muted small">{{ $log->description }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-clipboard fe-24 mb-2 d-block"></i>
                                                Belum ada aktivitas log yang tercatat.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Tambahkan style bootstrap agar tombol next/prev rapi --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $logs->links('pagination::bootstrap-4') }}
                    </div>

                </div>
            </div> 
        </div> 
    </div> 
</div>

{{-- PENTING: Tambahkan script ini agar DataTable tidak bentrok --}}
@push('scripts')
<script>
  $(document).ready(function() {
      if ($.fn.DataTable.isDataTable('#dataTable-1')) {
          $('#dataTable-1').DataTable().destroy();
      }

      $('#dataTable-1').DataTable({
          "paging": false,       // Matikan pagination JS
          "info": false,         // Matikan teks "Showing..."
          "searching": false,    // Matikan search box JS
          "lengthChange": false, // Matikan dropdown jumlah baris
          "autoWidth": true,
          "order": [],           // Biarkan urutan sesuai Controller (Latest)
          "columnDefs": [
              { "orderable": false, "targets": [0,1,2,3,4] } // Opsional: Matikan sorting klik header
          ]
      });
  });
</script>
@endpush

@endsection