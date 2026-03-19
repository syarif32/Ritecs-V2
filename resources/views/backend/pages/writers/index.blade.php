@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Writers</h2>
      <a href="{{ route('admin.writers.create') }}" class="btn btn-primary mb-3">+ Add Writer</a>
      <div class="card shadow">
        <div class="card-body">
          
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
          @endif

          <table class="table datatables" id="dataTable-1">
            <thead>
              <tr>
                <th>ID</th>
                <th>Writer Name</th>
                <th>ID - User Relation</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($writers as $writer)
              <tr>
                <td>{{ $writer->writer_id }}</td>
                <td>{{ $writer->name }}</td>
                <td>{{ $writer->user ? $writer->user->user_id : '' }} - {{ $writer->user ? $writer->user->full_name : 'Unrelated' }}</td>
                <td>{{ $writer->created_at }}</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="{{ route('admin.writers.edit', $writer->writer_id) }}">Edit</a>
                      <a class="dropdown-item" href="{{ route('admin.writers.delete', $writer->writer_id) }}" 
                        onclick="return confirm('Yakin hapus writer ini?')">Delete</a>
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
@endsection
