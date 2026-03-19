@extends('backend.layouts.main')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">Role Management</h2>
            <p class="card-text">Kelola hak akses administrator sistem. Gunakan fitur ini dengan bijak.</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="fe fe-check-circle fe-16 mr-2"></span> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="fe fe-alert-triangle fe-16 mr-2"></span> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>Pengguna</th>
                                        <th>Role Saat Ini</th>
                                        <th>Status Akun</th>
                                        <th>Terdaftar</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <img src="{{ $user->img_path ? asset($user->img_path) : asset('backend/assets/images/user.svg') }}" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div>
                                                    <p class="mb-0 text-muted"><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></p>
                                                    <small class="mb-0 text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-pill {{ $role->name == 'Admin' ? 'badge-primary' : 'badge-secondary' }}">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($user->acc_status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="text-right">
                                            @if($user->hasRole('Admin'))
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#demoteModal-{{ $user->user_id }}">
                                                    <i class="fe fe-shield-off fe-12 mr-1"></i> Demote
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#promoteModal-{{ $user->user_id }}">
                                                    <i class="fe fe-shield fe-12 mr-1"></i> Promote
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- MODAL PROMOTE -->
                                    <div class="modal fade" id="promoteModal-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hak Akses</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.users.promote', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="alert alert-warning">
                                                            <i class="fe fe-alert-triangle mr-2"></i> <strong>Tindakan Sensitif!</strong>
                                                        </div>
                                                        <p>Anda akan memberikan akses penuh <strong>ADMINISTRATOR</strong> kepada:</p>
                                                        <div class="card bg-light border-0 mb-3">
                                                            <div class="card-body p-2 d-flex align-items-center">
                                                                <div class="avatar avatar-sm mr-3">
                                                                    <img src="{{ $user->img_path ? asset($user->img_path) : asset('backend/assets/avatars/face-1.jpg') }}" class="avatar-img rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                                    <small>{{ $user->email }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Input Password dengan Toggle -->
                                                        <div class="form-group">
                                                            <label class="col-form-label">Masukkan Password Anda untuk konfirmasi:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" name="admin_password" id="pass-promote-{{ $user->user_id }}" required placeholder="Password Login Anda">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-secondary" type="button" onclick="togglePassword('pass-promote-{{ $user->user_id }}', this)">
                                                                        <i class="fe fe-eye"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Ya, Jadikan Admin</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL DEMOTE -->
                                    <div class="modal fade" id="demoteModal-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">Cabut Hak Akses</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.users.demote', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <p>Anda yakin ingin mencabut akses <strong>ADMIN</strong> dari pengguna ini?</p>
                                                        <div class="card bg-light border-0 mb-3">
                                                            <div class="card-body p-2">
                                                                <strong>{{ $user->first_name }} {{ $user->last_name }}</strong><br>
                                                                <small>{{ $user->email }}</small>
                                                            </div>
                                                        </div>
                                                        <p class="text-muted small">Pengguna akan kembali menjadi User biasa.</p>
                                                        
                                                        <!-- Input Password dengan Toggle -->
                                                        <div class="form-group">
                                                            <label class="col-form-label">Konfirmasi Password Anda:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" name="admin_password" id="pass-demote-{{ $user->user_id }}" required placeholder="Password Login Anda">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-secondary" type="button" onclick="togglePassword('pass-demote-{{ $user->user_id }}', this)">
                                                                        <i class="fe fe-eye"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Cabut Akses</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div> 


<script>
    function togglePassword(inputId, btn) {
        var input = document.getElementById(inputId);
        var icon = btn.querySelector('i');
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fe-eye');
            icon.classList.add('fe-eye-off'); 
        } else {
            input.type = "password";
            icon.classList.remove('fe-eye-off');
            icon.classList.add('fe-eye'); 
        }
    }
    
</script>
@push('scripts')
<script>
 $(document).ready(function() {
      
     
      if ($.fn.DataTable.isDataTable('#dataTable-1')) {
          $('#dataTable-1').DataTable().destroy();
      }

     
      $('#dataTable-1').DataTable({
          "paging": false,       
          "info": false,     
          "searching": false,   
          "lengthChange": false, 
          "autoWidth": true,
          "order": [],        
          "columnDefs": [
              { "orderable": false, "targets": 4 } 
          ]
      });
  });
</script>
@endpush

@endsection