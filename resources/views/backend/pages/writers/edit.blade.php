@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-6">
      <h2 class="page-title">Edit Writer</h2>
      <div class="card shadow mb-4">
        <div class="card-body">

          <form action="{{ route('admin.writers.update', $writer->writer_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Writer --}}
            <div class="form-group mb-3">
              <label for="name">Writer Name</label>
              <input type="text" 
                     class="form-control @error('name') is-invalid @enderror" 
                     id="name" 
                     name="name" 
                     value="{{ old('name', $writer->name) }}" 
                     required>
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Pilih User (opsional) --}}
            <div class="form-group mb-3">
              <label for="user_id">User Relations (Opsional)</label>
              <select class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id">
                <option value="">-- pilih user (opsional) --</option>
                @foreach($users as $user)
                  <option value="{{ $user->user_id }}"
                    {{ old('user_id', $writer->user_id) == $user->user_id ? 'selected' : '' }}>
                    {{ $user->user_id }} - {{ $user->full_name}} - {{$user->email}}
                  </option>
                @endforeach
              </select>
              @error('user_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.writers') }}" class="btn btn-secondary">Cancel</a>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
