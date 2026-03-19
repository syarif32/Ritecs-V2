@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Keywords</h2>
      <a href="{{ route('admin.keywords.create') }}" class="btn btn-primary mb-3">+ Add Keyword</a>
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
                <th>Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($keywords as $keyword)
              <tr>
                <td>{{ $keyword->keyword_id }}</td>
                <td>{{ $keyword->name }}</td>
                <td>{{ $keyword->created_at }}</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="{{ route('admin.keywords.edit', $keyword->keyword_id) }}">Edit</a>
                      <a class="dropdown-item" href="{{ route('admin.keywords.delete', $keyword->keyword_id) }}" onclick="return confirm('Yakin hapus keyword ini?')">Delete</a>
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
