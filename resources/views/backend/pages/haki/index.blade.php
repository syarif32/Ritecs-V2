@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Header Page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman Layanan HAKI</h1>
    </div>

    {{-- Notifikasi Error & Sukses --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- SECTION 1: KELOLA KONTEN INTRO --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-heading mr-2"></i>Kelola Konten Intro HAKI
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.page.haki.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Utama</label>
                            <input type="text" name="haki_intro_title" class="form-control" value="{{ $haki_intro_title->value }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Subjudul</label>
                            <input type="text" name="haki_intro_subtitle" class="form-control" value="{{ $haki_intro_subtitle->value }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi</label>
                            <textarea name="haki_intro_description" class="form-control" rows="5">{{ $haki_intro_description->value }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Konten Intro
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SECTION 2: KELOLA JENIS HAKI --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shapes mr-2"></i>Kelola Jenis Layanan HAKI
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addHakiTypeModal">
                <i class="fas fa-plus mr-1"></i> Tambah Jenis
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="10%" class="text-center">Ikon</th>
                            <th>Nama Jenis</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($haki_types as $item)
                            <tr>
                                <td class="text-center align-middle">
                                    <i class="{{ $item->icon }} fa-lg text-secondary"></i>
                                </td>
                                <td class="align-middle font-weight-bold">{{ $item->name }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editHakiTypeModal"
                                            data-item='{{ $item->toJson() }}'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.haki-types.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Belum ada data jenis HAKI.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SECTION 3: KELOLA PAKET HAKI --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-box-open mr-2"></i>Kelola Paket Layanan HAKI
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addHakiPackageModal">
                <i class="fas fa-plus mr-1"></i> Tambah Paket
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul Paket</th>
                            <th>Harga Baru</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($haki_packages as $item)
                            <tr>
                                <td class="align-middle font-weight-bold">{{ $item->title }}</td>
                                <td class="align-middle text-success font-weight-bold">
                                    Rp. {{ number_format($item->new_price, 0, ',', '.') }}
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm" 
                                            data-toggle="modal"
                                            data-target="#editHakiPackageModal" 
                                            data-item='{{ $item->toJson() }}'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.haki-packages.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Belum ada data paket HAKI.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ================================= MODALS ================================= --}}

{{-- 1. ADD HAKI TYPE MODAL --}}
<div class="modal fade" id="addHakiTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Jenis HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.haki-types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas Ikon</label>
                        <input type="text" name="icon" class="form-control input-icon-target" placeholder="Contoh: fas fa-copyright" required>
                    </div>

                    {{-- Icon Picker --}}
                    <div class="form-group border rounded p-3 bg-light">
                        <label class="small text-uppercase font-weight-bold text-muted mb-2">Pilih Ikon (Klik untuk menggunakan)</label>
                        <div class="icon-reference-grid">
                            @foreach(config('icons.font_awesome') as $icon)
                            <div class="icon-reference-item" onclick="selectIcon('{{ $icon['class'] }}')" title="{{ $icon['class'] }}">
                                <i class="{{ $icon['class'] }}"></i>
                                <span class="icon-class">{{ str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $icon['class']) }}</span>
                            </div>
                            @endforeach
                        </div>
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

{{-- 2. EDIT HAKI TYPE MODAL --}}
<div class="modal fade" id="editHakiTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Jenis HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas Ikon</label>
                        <input type="text" name="icon" class="form-control input-icon-target" required>
                    </div>

                    {{-- Icon Picker --}}
                    <div class="form-group border rounded p-3 bg-light">
                        <label class="small text-uppercase font-weight-bold text-muted mb-2">Pilih Ikon (Klik untuk mengganti)</label>
                        <div class="icon-reference-grid">
                            @foreach(config('icons.font_awesome') as $icon)
                            <div class="icon-reference-item" onclick="selectIcon('{{ $icon['class'] }}')" title="{{ $icon['class'] }}">
                                <i class="{{ $icon['class'] }}"></i>
                                <span class="icon-class">{{ str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $icon['class']) }}</span>
                            </div>
                            @endforeach
                        </div>
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

{{-- 3. ADD HAKI PACKAGE MODAL --}}
<div class="modal fade" id="addHakiPackageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Paket HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.haki-packages.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Paket</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Harga Lama (Coret)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" name="old_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Harga Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" name="new_price" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fitur (Pisahkan dengan koma)</label>
                        <textarea name="features" class="form-control" rows="3" placeholder="Contoh: Fitur A, Fitur B, Fitur C"></textarea>
                    </div>
                    
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" placeholder="628xxxxxxxxxx" required>
                            <small class="text-muted">Gunakan format 62, contoh: 6281234567890</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pesan WhatsApp</label>
                            <textarea name="whatsapp_message" class="form-control" required rows="1">Halo, saya tertarik dengan paket ini.</textarea>
                        </div>
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

{{-- 4. EDIT HAKI PACKAGE MODAL --}}
<div class="modal fade" id="editHakiPackageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Paket HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Paket</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Harga Lama (Coret)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" name="old_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Harga Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" name="new_price" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fitur (Pisahkan dengan koma)</label>
                        <textarea name="features" class="form-control" rows="3"></textarea>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" required>
                            <small class="text-muted">Gunakan format 62.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pesan WhatsApp</label>
                            <textarea name="whatsapp_message" class="form-control" required rows="1"></textarea>
                        </div>
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

@push('styles')
<style>
    /* Styling Grid Ikon yang Rapi */
    .icon-reference-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); 
        gap: 10px;
        max-height: 200px; /* Scrollable area */
        overflow-y: auto;
        padding: 5px;
        border: 1px solid #e3e6f0;
        background: #fff;
        border-radius: 5px;
    }
    
    .icon-reference-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px; 
        background-color: #f8f9fc;
        border: 1px solid #eaecf4;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem; 
    }

    .icon-reference-item:hover {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    
    .icon-reference-item:hover i {
        color: white;
    }

    .icon-reference-item .icon-class {
        font-family: 'Consolas', monospace;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fungsi Helper: Pilih Ikon
    function selectIcon(iconClass) {
        var activeModal = $('.modal.show');
        if (activeModal.length) {
            activeModal.find('.input-icon-target').val(iconClass);
        }
    }

    $(document).ready(function () {
        
        // Logic Edit Haki Types (Jenis)
        $('#editHakiTypeModal').on('show.bs.modal', function (e) {
            var item = $(e.relatedTarget).data('item');
            var form = $(this).find('form');
            
            form.attr('action', '{{ url("admin/haki-types") }}/' + item.id);
            form.find('[name="icon"]').val(item.icon);
            form.find('[name="name"]').val(item.name);
        });

        // Logic Edit Haki Packages (Paket)
        $('#editHakiPackageModal').on('show.bs.modal', function (e) {
            var item = $(e.relatedTarget).data('item');
            var form = $(this).find('form');
            
            form.attr('action', '{{ url("admin/haki-packages") }}/' + item.id);
            form.find('[name="title"]').val(item.title);
            form.find('[name="old_price"]').val(item.old_price);
            form.find('[name="new_price"]').val(item.new_price);
            form.find('[name="description"]').val(item.description);
            form.find('[name="whatsapp_number"]').val(item.whatsapp_number);
            form.find('[name="whatsapp_message"]').val(item.whatsapp_message);
            
            // Logic Array Features (Tetap Sama)
            if (Array.isArray(item.features)) {
                form.find('[name="features"]').val(item.features.join(', '));
            } else {
                 form.find('[name="features"]').val(item.features);
            }
        });
    });
</script>
@endpush