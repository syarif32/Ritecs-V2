@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Header Page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman Tim</h1>
    </div>
    
    {{-- Notifikasi --}}
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

    {{-- SECTION 1: PENGATURAN HALAMAN --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-heading mr-2"></i>Pengaturan Judul & Deskripsi
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.page.team.updateSettings') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Pre-Judul <small class="text-muted">(Teks kecil di atas judul)</small></label>
                            <input type="text" id="team_pre_title" name="team_pre_title" class="form-control" value="{{ $settings['team_pre_title'] ?? 'Our Team' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Utama</label>
                            <input type="text" id="team_title" name="team_title" class="form-control" value="{{ $settings['team_title'] ?? 'Meet Our Expert Team Members' }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Deskripsi Halaman</label>
                    <textarea id="team_description" name="team_description" class="form-control" rows="3">{{ $settings['team_description'] ?? '' }}</textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SECTION 2: DAFTAR ANGGOTA TIM --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-2"></i>Daftar Anggota Tim
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTeamModal">
                <i class="fas fa-user-plus mr-1"></i> Tambah Anggota
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="10%" class="text-center">Foto</th>
                            <th>Info Anggota</th>
                            <th>Posisi</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teams as $item)
                        <tr>
                            <td class="text-center align-middle">
                                <img src="{{ asset('storage/' . $item->img_path) }}" alt="{{ $item->name }}" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td class="align-middle">
                                <span class="font-weight-bold text-dark">{{ $item->name }}</span>
                                <div class="small mt-1">
                                    @if($item->linkedin_url) <a href="{{ $item->linkedin_url }}" target="_blank" class="mr-2"><i class="fab fa-linkedin text-primary"></i></a> @endif
                                    @if($item->instagram_url) <a href="{{ $item->instagram_url }}" target="_blank" class="mr-2"><i class="fab fa-instagram text-danger"></i></a> @endif
                                    @if($item->facebook_url) <a href="{{ $item->facebook_url }}" target="_blank" class="mr-2"><i class="fab fa-facebook text-primary"></i></a> @endif
                                    @if($item->twitter_url) <a href="{{ $item->twitter_url }}" target="_blank"><i class="fab fa-twitter text-info"></i></a> @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-secondary px-2 py-1">{{ $item->position }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTeamModal"
                                        data-id="{{ $item->team_id }}"
                                        data-name="{{ $item->name }}"
                                        data-position="{{ $item->position }}"
                                        data-facebook_url="{{ $item->facebook_url }}"
                                        data-twitter_url="{{ $item->twitter_url }}"
                                        data-linkedin_url="{{ $item->linkedin_url }}"
                                        data-instagram_url="{{ $item->instagram_url }}"
                                        data-img_path="{{ asset('storage/' . $item->img_path) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.page.team.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Belum ada anggota tim.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH ANGGOTA --}}
<div class="modal fade" id="addTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Anggota Tim</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.page.team.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Posisi / Jabatan</label>
                                <input type="text" name="position" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto (Max: 2MB)</label>
                        <div class="custom-file">
                            <input type="file" name="img_path" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Pilih file...</label>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-share-alt mr-1"></i> Sosial Media (Opsional)</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook"></i></span></div>
                                    <input type="url" name="facebook_url" class="form-control" placeholder="URL Facebook">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-twitter"></i></span></div>
                                    <input type="url" name="twitter_url" class="form-control" placeholder="URL Twitter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-linkedin"></i></span></div>
                                    <input type="url" name="linkedin_url" class="form-control" placeholder="URL LinkedIn">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                    <input type="url" name="instagram_url" class="form-control" placeholder="URL Instagram">
                                </div>
                            </div>
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

{{-- MODAL EDIT ANGGOTA --}}
<div class="modal fade" id="editTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Anggota Tim</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTeamForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" id="edit_name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Posisi / Jabatan</label>
                                <input type="text" id="edit_position" name="position" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <img id="current_image" src="" width="80" class="img-thumbnail rounded" alt="Current Image">
                        </div>
                        <div class="col">
                            <label>Ganti Foto (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" name="img_path" class="custom-file-input" id="customFileEdit">
                                <label class="custom-file-label" for="customFileEdit">Pilih file baru...</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-share-alt mr-1"></i> Sosial Media (Opsional)</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook"></i></span></div>
                                    <input type="url" id="edit_facebook_url" name="facebook_url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-twitter"></i></span></div>
                                    <input type="url" id="edit_twitter_url" name="twitter_url" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-linkedin"></i></span></div>
                                    <input type="url" id="edit_linkedin_url" name="linkedin_url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                    <input type="url" id="edit_instagram_url" name="instagram_url" class="form-control">
                                </div>
                            </div>
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

@push('scripts')
<script>
    // Custom File Input Label (Agar nama file muncul saat dipilih)
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(document).ready(function() {
        $('#editTeamModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            // Ambil data dari tombol
            var id = button.data('id');
            var name = button.data('name');
            var position = button.data('position');
            var facebook_url = button.data('facebook_url');
            var twitter_url = button.data('twitter_url');
            var linkedin_url = button.data('linkedin_url');
            var instagram_url = button.data('instagram_url');
            var img_path = button.data('img_path');

            // Isi input di modal
            modal.find('#edit_name').val(name);
            modal.find('#edit_position').val(position);
            modal.find('#edit_facebook_url').val(facebook_url);
            modal.find('#edit_twitter_url').val(twitter_url);
            modal.find('#edit_linkedin_url').val(linkedin_url);
            modal.find('#edit_instagram_url').val(instagram_url);
            modal.find('#current_image').attr('src', img_path);

            // Reset label input file
            modal.find('.custom-file-label').html('Pilih file baru...');

            // Update Action URL
            var actionUrl = '{{ url("admin/page/team/update") }}/' + id;
            modal.find('#editTeamForm').attr('action', actionUrl);
        });
    });
</script>
@endpush