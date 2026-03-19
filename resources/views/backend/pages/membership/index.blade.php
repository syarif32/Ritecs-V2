@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Header Page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman Membership</h1>
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

    {{-- SECTION 1: KELOLA HARGA --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tags mr-2"></i>Kelola Harga Membership
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.page.membership.updatePrice') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price" class="font-weight-bold">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp / IDR</span>
                            </div>
                            <input type="text" id="price" name="price" class="form-control" value="{{ $price->value }}" placeholder="Contoh: 150K" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price_description" class="font-weight-bold">Deskripsi Singkat Harga</label>
                        <input type="text" id="price_description" name="price_description" class="form-control" value="{{ $price_description->value }}" placeholder="Contoh: per bulan" required>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Harga
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        {{-- SECTION 2: KELOLA KEUNTUNGAN (BENEFITS) --}}
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star mr-2"></i>Daftar Keuntungan
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBenefitModal">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">Ikon</th>
                                    <th>Detail Keuntungan</th>
                                    <th width="15%" class="text-center">Unggulan</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($benefits as $benefit)
                                <tr>
                                    <td class="text-center align-middle">
                                        <i class="{{ $benefit->icon }} fa-lg text-secondary"></i>
                                    </td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold d-block">{{ $benefit->title }}</span>
                                        <small class="text-muted">{{ Str::limit($benefit->description, 60) }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($benefit->is_featured)
                                            <span class="badge badge-success">Ya</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm edit-benefit-btn" 
                                                data-toggle="modal" 
                                                data-target="#editBenefitModal"
                                                data-id="{{ $benefit->id }}"
                                                data-icon="{{ $benefit->icon }}"
                                                data-title="{{ $benefit->title }}"
                                                data-description="{{ $benefit->description }}"
                                                data-is_featured="{{ $benefit->is_featured }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.benefits.destroy', $benefit) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus keuntungan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada data keuntungan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: KELOLA FAQ --}}
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-question-circle mr-2"></i>FAQ
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFaqModal">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanya Jawab</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faqs as $faq)
                                <tr>
                                    <td>
                                        <strong class="d-block text-dark"><i class="fas fa-caret-right mr-1"></i> {{ Str::limit($faq->question, 40) }}</strong>
                                        <small class="text-muted">{{ Str::limit($faq->answer, 60) }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm edit-faq-btn" 
                                                data-toggle="modal" 
                                                data-target="#editFaqModal"
                                                data-id="{{ $faq->id }}"
                                                data-question="{{ $faq->question }}"
                                                data-answer="{{ $faq->answer }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus FAQ ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-3 text-muted">Belum ada data FAQ.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ================================= MODALS ================================= --}}

{{-- 1. ADD BENEFIT MODAL --}}
<div class="modal fade" id="addBenefitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- Header Putih --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Keuntungan Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.benefits.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Keuntungan</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas Ikon</label>
                                <input type="text" name="icon" class="form-control input-icon-target" placeholder="Contoh: fas fa-check" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>

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

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="is_featured_add">
                        <label class="form-check-label" for="is_featured_add">
                            Jadikan Unggulan (Tampil di Kartu Harga Utama)
                        </label>
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

{{-- 2. EDIT BENEFIT MODAL --}}
<div class="modal fade" id="editBenefitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- Header Putih --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Keuntungan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBenefitForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Keuntungan</label>
                                <input type="text" id="edit_title" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas Ikon</label>
                                <input type="text" id="edit_icon" name="icon" class="form-control input-icon-target" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="2" required></textarea>
                    </div>

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

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="edit_is_featured">
                        <label class="form-check-label" for="edit_is_featured">
                            Jadikan Unggulan
                        </label>
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

{{-- 3. ADD FAQ MODAL --}}
<div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah FAQ Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="text" name="question" class="form-control" placeholder="Contoh: Apakah ada refund?" required>
                    </div>
                    <div class="form-group">
                        <label>Jawaban</label>
                        <textarea name="answer" class="form-control" rows="4" required></textarea>
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

{{-- 4. EDIT FAQ MODAL --}}
<div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit FAQ</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editFaqForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="text" id="edit_question" name="question" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jawaban</label>
                        <textarea id="edit_answer" name="answer" class="form-control" rows="4" required></textarea>
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
        /* Ubah ukuran dari 200px menjadi 140px agar lebih banyak item per baris */
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); 
        gap: 10px;
        max-height: 250px; /* Scroll area */
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
        padding: 5px 8px; /* Padding lebih kecil agar compact */
        background-color: #f8f9fc;
        border: 1px solid #eaecf4;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem; /* Ukuran font sedikit lebih kecil */
    }

    .icon-reference-item:hover {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .icon-reference-item i {
        width: 20px;
        text-align: center;
        font-size: 1rem;
    }
    
    /* Warna ikon saat hover ikut putih */
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
    // Fungsi Helper: Pilih Ikon saat diklik di dalam Modal
    function selectIcon(iconClass) {
        // Cari modal yang sedang terbuka (memiliki class 'show')
        var activeModal = $('.modal.show');
        if (activeModal.length) {
            // Isi input dengan class .input-icon-target di dalam modal tersebut
            activeModal.find('.input-icon-target').val(iconClass);
        }
    }

    $(document).ready(function() {
        
        // 1. Logic Modal Edit Benefit
        $('#editBenefitModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            
            // Ambil data dari tombol edit
            var id = button.data('id');
            var icon = button.data('icon');
            var title = button.data('title');
            var description = button.data('description');
            var isFeatured = button.data('is_featured');
            
            var modal = $(this);
            var form = modal.find('#editBenefitForm');
            
            // Set Action URL dinamis
            var actionUrl = '{{ url("admin/benefits") }}/' + id;
            form.attr('action', actionUrl);
            
            // Populate Input Fields
            modal.find('#edit_icon').val(icon);
            modal.find('#edit_title').val(title);
            modal.find('#edit_description').val(description);
            modal.find('#edit_is_featured').prop('checked', isFeatured == 1);
        });

        // 2. Logic Modal Edit FAQ
        $('#editFaqModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            
            // Ambil data
            var id = button.data('id');
            var question = button.data('question');
            var answer = button.data('answer');
            
            var modal = $(this);
            var form = modal.find('#editFaqForm');
            
            // Set Action URL
            var actionUrl = '{{ url("admin/faqs") }}/' + id;
            form.attr('action', actionUrl);
            
            // Populate
            modal.find('#edit_question').val(question);
            modal.find('#edit_answer').val(answer);
        });
    });
</script>
@endpush