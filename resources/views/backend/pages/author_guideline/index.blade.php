@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
    
    {{-- Header Page --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="page-title">Kelola Halaman Layanan Buku</h2>
            <p class="text-muted">Atur konten teks judul, jenis buku, skema, dan prosedur penerbitan.</p>
        </div>
    </div>
    
    {{-- Alert Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fe fe-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- SECTION 1: KELOLA JUDUL & SUBJUDUL (Grid Layout) --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-type mr-2"></i>Konfigurasi Judul & Subjudul Halaman</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.page.author-guideline.update') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Kolom 1: Jenis Buku --}}
                    <div class="col-md-4 border-right">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Bagian Jenis Buku</h6>
                        <div class="form-group">
                            <label for="guideline_bt_title" class="small">Judul Utama</label>
                            <input type="text" id="guideline_bt_title" name="guideline_bt_title" class="form-control" value="{{ $book_types_title->value }}">
                        </div>
                        <div class="form-group">
                            <label for="guideline_bt_subtitle" class="small">Subjudul</label>
                            <input type="text" id="guideline_bt_subtitle" name="guideline_bt_subtitle" class="form-control" value="{{ $book_types_subtitle->value }}">
                        </div>
                    </div>

                    {{-- Kolom 2: Skema Penerbitan --}}
                    <div class="col-md-4 border-right">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Bagian Skema Penerbitan</h6>
                        <div class="form-group">
                            <label for="guideline_ps_title" class="small">Judul Utama</label>
                            <input type="text" id="guideline_ps_title" name="guideline_ps_title" class="form-control" value="{{ $schemes_title->value }}">
                        </div>
                        <div class="form-group">
                            <label for="guideline_ps_subtitle" class="small">Subjudul</label>
                            <input type="text" id="guideline_ps_subtitle" name="guideline_ps_subtitle" class="form-control" value="{{ $schemes_subtitle->value }}">
                        </div>
                    </div>

                    {{-- Kolom 3: Prosedur --}}
                    <div class="col-md-4">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Bagian Prosedur</h6>
                        <div class="form-group">
                            <label for="guideline_st_title" class="small">Judul Utama</label>
                            <input type="text" id="guideline_st_title" name="guideline_st_title" class="form-control" value="{{ $steps_title->value }}">
                        </div>
                        <div class="form-group">
                            <label for="guideline_st_subtitle" class="small">Subjudul</label>
                            <input type="text" id="guideline_st_subtitle" name="guideline_st_subtitle" class="form-control" value="{{ $steps_subtitle->value }}">
                        </div>
                    </div>
                </div>
                
                <hr class="mt-4">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save mr-1"></i> Simpan Semua Judul
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        
        {{-- SECTION 2: JENIS BUKU (Kiri) --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-book mr-2"></i>Jenis Buku</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBookTypeModal">
                        <i class="fe fe-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="15%" class="text-center">Ikon</th>
                                    <th>Nama Jenis</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($book_types as $item)
                                <tr>
                                    <td class="text-center align-middle"><i class="{{ $item->icon }} fa-lg text-secondary"></i></td>
                                    <td class="align-middle font-weight-bold">{{ $item->name }}</td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editBookTypeModal"
                                                data-id="{{ $item->id }}" data-icon="{{ $item->icon }}" data-name="{{ $item->name }}" title="Edit">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.book-types.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus jenis buku ini?')" title="Hapus">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada data jenis buku.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: SKEMA PENERBITAN (Kanan) --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-layers mr-2"></i>Skema Penerbitan</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSchemeModal">
                        <i class="fe fe-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%" class="text-center">Ikon</th>
                                    <th>Judul & Fitur</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($publishing_schemes as $item)
                                <tr>
                                    <td class="text-center align-middle"><i class="{{ $item->icon }} fa-lg text-info"></i></td>
                                    <td class="align-middle">
                                        <span class="d-block font-weight-bold text-dark">{{ $item->title }}</span>
                                        <small class="text-muted"><i class="fe fe-star mr-1"></i>{{ $item->feature }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editSchemeModal"
                                                data-id="{{ $item->id }}" data-icon="{{ $item->icon }}" data-title="{{ $item->title }}"
                                                data-description="{{ $item->description }}" data-feature="{{ $item->feature }}" title="Edit">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.publishing-schemes.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus skema ini?')" title="Hapus">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada data skema.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- SECTION 4: PROSEDUR / TIMELINE (Full Width) --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-list mr-2"></i>Prosedur & Tahapan Penerbitan</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addStepModal">
                        <i class="fe fe-plus"></i> Tambah Tahap
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="25%">Tahapan</th>
                                    <th>Deskripsi Detail</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($publishing_steps as $item)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                    <td class="align-middle font-weight-bold text-dark">{{ $item->title }}</td>
                                    <td class="align-middle text-muted small">{{ Str::limit($item->description, 100) }}</td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editStepModal"
                                                data-id="{{ $item->id }}" data-title="{{ $item->title }}" data-description="{{ $item->description }}">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.publishing-steps.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus tahapan ini?')">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada data tahapan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- ================= MODALS (LOGIC PRESERVED) ================= --}}

{{-- 1. MODAL BOOK TYPE --}}
<div class="modal fade" id="addBookTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Jenis Buku</h5></div>
            <form action="{{ route('admin.book-types.store') }}" method="POST">
                @csrf 
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis Buku</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Monograf" required>
                    </div>
                    <div class="form-group">
                        <label>Class Ikon (FontAwesome/Feather)</label>
                        <input type="text" name="icon" class="form-control" placeholder="Contoh: fe fe-book" required>
                    </div>
                    <div class="alert alert-info py-2 small mb-0">
                        @include('backend.partials.icon_reference')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBookTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Jenis Buku</h5></div>
            <form id="editBookTypeForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_bt_name">Nama Jenis Buku</label>
                        <input type="text" id="edit_bt_name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_bt_icon">Class Ikon</label>
                        <input type="text" id="edit_bt_icon" name="icon" class="form-control" required>
                    </div>
                    <div class="alert alert-info py-2 small mb-0">
                        @include('backend.partials.icon_reference')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. MODAL PUBLISHING SCHEME --}}
<div class="modal fade" id="addSchemeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Skema</h5></div>
            <form action="{{ route('admin.publishing-schemes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Skema</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fitur Unggulan</label>
                                <input type="text" name="feature" class="form-control" placeholder="Contoh: Proses Cepat" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ikon</label>
                        <input type="text" name="icon" class="form-control" required>
                    </div>
                    <div class="alert alert-info py-2 small mb-0">@include('backend.partials.icon_reference')</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editSchemeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Skema</h5></div>
            <form id="editSchemeForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label for="edit_ps_title">Judul Skema</label><input type="text" id="edit_ps_title" name="title" class="form-control" required></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label for="edit_ps_feature">Fitur Unggulan</label><input type="text" id="edit_ps_feature" name="feature" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="form-group"><label for="edit_ps_description">Deskripsi</label><textarea id="edit_ps_description" name="description" class="form-control" rows="3" required></textarea></div>
                    <div class="form-group"><label for="edit_ps_icon">Ikon</label><input type="text" id="edit_ps_icon" name="icon" class="form-control" required></div>
                    <div class="alert alert-info py-2 small mb-0">@include('backend.partials.icon_reference')</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. MODAL PUBLISHING STEP --}}
<div class="modal fade" id="addStepModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Tahap</h5></div>
            <form action="{{ route('admin.publishing-steps.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Tahapan</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStepModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Tahap</h5></div>
            <form id="editStepForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_st_title">Judul Tahapan</label>
                        <input type="text" id="edit_st_title" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_st_description">Deskripsi</label>
                        <textarea id="edit_st_description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Modal Edit Book Type
    $('#editBookTypeModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_bt_name').val(button.data('name'));
        $('#edit_bt_icon').val(button.data('icon'));
        var action = '{{ url("admin/book-types") }}/' + button.data('id');
        $('#editBookTypeForm').attr('action', action);
    });

    // Modal Edit Publishing Scheme
    $('#editSchemeModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_ps_title').val(button.data('title'));
        $('#edit_ps_description').val(button.data('description'));
        $('#edit_ps_feature').val(button.data('feature'));
        $('#edit_ps_icon').val(button.data('icon'));
        var action = '{{ url("admin/publishing-schemes") }}/' + button.data('id');
        $('#editSchemeForm').attr('action', action);
    });

    // Modal Edit Publishing Step
    $('#editStepModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_st_title').val(button.data('title'));
        $('#edit_st_description').val(button.data('description'));
        var action = '{{ url("admin/publishing-steps") }}/' + button.data('id');
        $('#editStepForm').attr('action', action);
    });
});
</script>
@endpush