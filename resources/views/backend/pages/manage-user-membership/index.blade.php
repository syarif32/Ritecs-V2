@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12">

      <h2 class="page-title">Membership Data</h2>
      <p class="card-text">List of membership user data.</p>

      <a href="{{ route('admin.manageUserMemberships.create') }}" class="btn btn-primary mb-3" onclick="return confirm('Menambahkan data membership tanpa transaksi akan menyebabkan inkonsistensi data!')">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add Membership</a>

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
                    <th>Member Number</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Period Start - End</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($memberships as $m)
                  <tr>
                    <td>{{ $m->member_number }}</td>
                    <td>
                      @if($m->user)
                        {{ $m->user->full_name }}
                      @else
                        {{ $m->guest_first_name }} {{ $m->guest_last_name }}
                      @endif
                    </td>
                    <td>
                      @if($m->user)
                        {{ $m->user->email }}
                      @else
                        {{ $m->guest_email }}
                      @endif
                    </td>
                    <td>
                        @if(!empty($m->user->nik))
                          {{ $m->user->nik }}
                        @else
                          <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                        @endif

                    </td>
                    <td>
                      @php
                        $now = now();
                        if($m->start_date <= $now && $m->end_date >= $now){
                            $icon = '<span class="fe fe-10 fe-check text-dark mr-2 bg-success rounded-pill"></span>
                                    <span class="text-success">' . $m->start_date . ' - ' . $m->end_date . '</span>';
                        } else {
                            $icon = '<span class="fe fe-10 fe-x text-dark mr-2 bg-warning rounded-pill"></span>
                                    <span class="text-warning">' . $m->start_date . ' - ' . $m->end_date . '</span>';
                        }
                      @endphp
                      {!! $icon !!}
                    </td>


                    <td>
                      @if($m->user)
                        <span class="pt-1 badge text-dark fw-bold">User</span>
                      @else
                        <span class="pt-1 badge text-seccondary">Guest</span>
                      @endif
                    </td>


                    <td>
                      @php
                        $badge = $m->status == 1 ? 'success' : 'danger';
                        $label = $m->status == 1 ? 'Active' : 'Inactive';
                      @endphp
                      <span class="pt-1 badge badge-{{ $badge }}">{{ $label }}</span>
                    </td>
                    
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.manageUserMemberships.edit',$m->membership_id) }}">Edit</a>
                        @if($m->status == 1)
                        <a class="dropdown-item text-warning" 
                          href="{{ route('admin.manageUserMemberships.destroy',$m->membership_id) }}" 
                          onclick="return confirm('Deactivate this membership?')">Deactivate</a>
                        @else
                        <a class="dropdown-item text-success" 
                          href="{{ route('admin.manageUserMemberships.restore',$m->membership_id) }}">Activate</a>
                        @endif
                         <a class="dropdown-item text-danger" 
                          href="{{ route('admin.manageUserMemberships.forceDelete',$m->membership_id) }}" 
                          onclick="return confirm('Yakin ingin menghapus data membership ini?') && confirm('Menghapus data membership akan menyebabkan inkonsistensi data user dengan langganan. Lanjutkan?')"
                          >Remove</a>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              {{ $memberships->links() }}
            </div>
          </div>
        </div> 
      </div>

    </div>
  </div>
</div>
@endsection
