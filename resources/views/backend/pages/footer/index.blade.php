@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Header Page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Konten Footer</h1>
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

    {{-- CARD 1: KONTAK & SOSMED --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle mr-2"></i>Info Kontak, Sosial Media & Judul Galeri
                
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.page.footer.updateSettings') }}" method="POST">
                @csrf
                
                <div class="row">
                    
                    <div class="col-lg-6 mb-4">
                       <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-2">
    <h6 class="text-uppercase text-gray-800 font-weight-bold m-0">Informasi Kontak</h6>
</div>


<p class="small text-muted mb-4">
    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
    <span class="font-italic">
        Catatan: Informasi kontak terhubung dengan <strong>Halaman Kontak</strong>. Jika Anda sudah mengubah informasi kontak di halaman kontak, biarkan saja bagian ini.
    </span>
</p>
                        <div class="form-group">
                            <label class="font-weight-bold">Alamat Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <textarea name="contact_address" class="form-control" rows="4">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Telepon / WhatsApp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Sosmed & Lainnya --}}
                    <div class="col-lg-6 mb-4">
                        <h6 class="text-uppercase text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Sosial Media</h6>

                        <div class="form-group">
                            <label>Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook-f"></i></span></div>
                                <input type="url" name="social_facebook" class="form-control" placeholder="https://facebook.com/..." value="{{ $settings['social_facebook'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Twitter / X</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-twitter"></i></span></div>
                                <input type="url" name="social_twitter" class="form-control" placeholder="https://twitter.com/..." value="{{ $settings['social_twitter'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Instagram</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                <input type="url" name="social_instagram" class="form-control" placeholder="https://instagram.com/..." value="{{ $settings['social_instagram'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>LinkedIn</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-linkedin-in"></i></span></div>
                                <input type="url" name="social_linkedin" class="form-control" placeholder="https://linkedin.com/in/..." value="{{ $settings['social_linkedin'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-uppercase text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Lainnya</h6>
                            <div class="form-group">
                                <label for="footer_instagram_title" class="font-weight-bold">Judul Galeri Footer</label>
                                <input type="text" id="footer_instagram_title" name="footer_instagram_title" class="form-control"
                                    value="{{ $settings['footer_instagram_title'] ?? 'Instagram' }}">
                                <small class="text-muted">Teks yang muncul di atas deretan gambar di footer.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- CARD 2: GALERI --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-images mr-2"></i>Kelola Gambar Galeri
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addGalleryModal">
                <i class="fas fa-plus mr-1"></i> Tambah Gambar
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="15%" class="text-center">Gambar</th>
                            <th>Link URL</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($footer_galleries as $gallery)
                            <tr>
                                <td class="text-center align-middle">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="gallery" class="img-thumbnail rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                </td>
                                <td class="align-middle">
                                    @if($gallery->link_url)
                                        <a href="{{ $gallery->link_url }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt mr-1"></i> {{ Str::limit($gallery->link_url, 50) }}
                                        </a>
                                    @else
                                        <span class="text-muted font-italic">- Tidak ada link -</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editGalleryModal"
                                            data-id="{{ $gallery->id }}" 
                                            data-link_url="{{ $gallery->link_url }}"
                                            data-image_path="{{ asset('storage/' . $gallery->image_path) }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.footer-galleries.destroy', $gallery) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Belum ada gambar di galeri footer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL TAMBAH GAMBAR --}}
<div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Gambar Galeri</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.footer-galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <div class="custom-file">
                            <input type="file" name="image_path" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Pilih file...</label>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, JPEG. Max: 2MB.</small>
                    </div>
                    <div class="form-group">
                        <label>Link URL (Opsional)</label>
                        <input type="url" name="link_url" class="form-control" placeholder="https://instagram.com/p/...">
                        <small class="text-muted">Link yang dituju ketika gambar diklik.</small>
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

{{-- MODAL EDIT GAMBAR --}}
<div class="modal fade" id="editGalleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Gambar Galeri</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <img id="edit_image_preview" src="" alt="preview" class="img-thumbnail rounded" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col">
                            <label>Ganti Gambar (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" name="image_path" class="custom-file-input" id="customFileEdit">
                                <label class="custom-file-label" for="customFileEdit">Pilih file baru...</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Link URL (Opsional)</label>
                        <input type="url" id="edit_link_url" name="link_url" class="form-control">
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
        // Custom File Input Label Logic
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).ready(function () {
            // Edit Gallery Modal Logic
            $('#editGalleryModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);

                var form = $('#editGalleryForm');
                var actionUrl = '{{ url("admin/footer-galleries") }}/' + id;
                form.attr('action', actionUrl);

                modal.find('#edit_image_preview').attr('src', button.data('image_path'));
                modal.find('#edit_link_url').val(button.data('link_url'));
                
                // Reset custom file label
                modal.find('.custom-file-label').html('Pilih file baru...');
            });
        });
    </script>
@endpush