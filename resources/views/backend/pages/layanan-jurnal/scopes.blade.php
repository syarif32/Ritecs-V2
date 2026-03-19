@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ isset($scope) ? 'Edit' : 'Tambah' }} Topik Ruang Lingkup</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ isset($scope) ? route('admin.scopes.update', $scope) : route('admin.scopes.store') }}" method="POST">
                @csrf
                @if (isset($scope))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Nama Topik</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $scope->name ?? '') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.page.journal-service.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection