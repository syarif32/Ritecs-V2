@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <h2 class="page-title">Bank Data</h2>
      <p class="card-text">List of banks data.</p>

      <a href="{{ route('admin.banks.create') }}" class="btn btn-primary mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add Bank
      </a>

      <div class="card shadow">
        <div class="card-body">

          {{-- Success Message --}}
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          @endif

          {{-- Error Message --}}
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
                <th>Bank Name</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($banks as $bank)
              <tr>
                <td>{{ $bank->bank_name }}</td>
                <td>{{ $bank->account_name }}</td>
                <td>{{ $bank->account_number }}</td>
                <td>
                  <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                    <span class="text-muted sr-only">Action</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.banks.edit',$bank->bank_id) }}">Edit</a>
                    <form action="{{ route('admin.banks.destroy',$bank->bank_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bank ini?')" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item text-danger">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          {{ $banks->links() }}
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
