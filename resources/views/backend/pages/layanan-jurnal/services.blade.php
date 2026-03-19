@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ isset($service) ? 'Edit' : 'Tambah' }} Layanan</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST">
                @csrf
                @if (isset($service))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="icon">Ikon</label>
                    <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon', $service->icon ?? '') }}" required>
                    <small class="form-text text-muted">Ketik manual nama kelas ikon dari referensi di bawah (contoh: `fas fa-unlock`).</small>
                </div>
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $service->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" required>{{ old('description', $service->description ?? '') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.page.journal-service.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Referensi Ikon</h6>
        </div>
        <div class="card-body">
            <div class="icon-reference-grid">
                @foreach($icons as $icon)
                <div class="icon-reference-item">
                    
                    <i class="{{ $icon['class'] }} fa-lg"></i>
                    
                    <span class="icon-class">{{ $icon['class'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection


<style>
    .icon-reference-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 10px;
        max-height: 400px;
        overflow-y: auto;
    }
    .icon-reference-item {
        display: flex;
        align-items: center;
        gap: 15px; 
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
    .icon-reference-item i {
        width: 20px; 
        text-align: center;
        color: #0d6efd; 
    }
    .icon-reference-item .icon-class {
        font-family: monospace; 
        font-size: 0.9em;
        color: #495057;
    }
</style>