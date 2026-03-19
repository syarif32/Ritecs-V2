@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-6">
      <h2 class="page-title">Edit Keyword</h2>
      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="{{ route('admin.keywords.update', $keyword->keyword_id) }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Keyword Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $keyword->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.keywords') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
