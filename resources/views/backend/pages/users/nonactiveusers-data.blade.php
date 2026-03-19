@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <h2 class="page-title">User Data</h2>
      <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool for advanced table features.</p>


      <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add User</a>

      <div class="row my-4">
        <div class="col-md-12">

        <div class="card shadow">
          <div class="card-body">

          {{-- Success Message --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            @endif

            {{-- Error Message (umum) --}}
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            @endif

            {{-- Validation Errors --}}
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


            <table class="table datatables" id="dataTable-1">
              <thead>
                <tr>
                  <th>Profile</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>NIK</th>
                  <th>Acc Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>
                    <a href="{{ asset($user->img_path) }}" target="_blank">
                      <div class="avatar avatar-sm">
                        <img src="{{ asset($user->img_path) }}" class="avatar-img rounded cover"
                        style="width:30px; height:30px; object-fit:cover;">
                      </div>
                    </a>
                  </td>
                  <td>
                    @if(!empty($user->full_name))
                      {{ $user->full_name }}
                    @else
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    @endif
                  </td>

                  <td>
                    @if(!empty($user->email))
                      {{ $user->email }}
                    @else
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    @endif
                  </td>

                  <td>
                    @if(!empty($user->phone))
                      {{ $user->phone }}
                    @else
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    @endif
                  </td>

                  <td>
                    @if(!empty($user->nik))
                      {{ $user->nik }}
                    @else
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    @endif
                  </td>

                  <td>
                    @php
                        // Account Status
                        $accStatus = $user->acc_status == 1 ? 'Active' : 'Nonactive';
                        $accColor  = $user->acc_status == 1 ? 'success' : 'warning';
                    @endphp

                    <span class="pt-1 badge badge-pill badge-{{ $accColor }}">
                        {{ $accStatus }}
                    </span>
                  </td>


                  <td>
                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="{{ route('admin.users.edit',$user->user_id) }}">Edit</a>
                      @if($user->acc_status == 1)
                      <a class="dropdown-item text-danger" 
                        href="{{ route('admin.users.destroy',$user->user_id) }}" 
                        onclick="return confirm('Yakin ingin menonaktifkan User?')">Nonactive
                      </a>
                      @else
                      <a class="dropdown-item text-success" href="{{ route('admin.users.restore',$user->user_id) }}">Activate</a>
                      @endif
                    </div>
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
            {{ $users->links() }}
          </div>
        </div>
        </div>
      </div>
      

    </div>
  </div>
</div>
@endsection
