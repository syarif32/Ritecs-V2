<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Konten Footer</h1>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle mr-2"></i>Info Kontak, Sosial Media & Judul Galeri
            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.footer.updateSettings')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    
                    <div class="col-lg-6 mb-4">
                        <h6 class="text-uppercase text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Informasi Kontak</h6>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Alamat Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <textarea name="contact_address" class="form-control" rows="4"><?php echo e($settings['contact_address'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="contact_email" class="form-control" value="<?php echo e($settings['contact_email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Telepon / WhatsApp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="contact_phone" class="form-control" value="<?php echo e($settings['contact_phone'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-6 mb-4">
                        <h6 class="text-uppercase text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Sosial Media</h6>

                        <div class="form-group">
                            <label>Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook-f"></i></span></div>
                                <input type="url" name="social_facebook" class="form-control" placeholder="https://facebook.com/..." value="<?php echo e($settings['social_facebook'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Twitter / X</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-twitter"></i></span></div>
                                <input type="url" name="social_twitter" class="form-control" placeholder="https://twitter.com/..." value="<?php echo e($settings['social_twitter'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Instagram</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                <input type="url" name="social_instagram" class="form-control" placeholder="https://instagram.com/..." value="<?php echo e($settings['social_instagram'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>LinkedIn</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-linkedin-in"></i></span></div>
                                <input type="url" name="social_linkedin" class="form-control" placeholder="https://linkedin.com/in/..." value="<?php echo e($settings['social_linkedin'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-uppercase text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Lainnya</h6>
                            <div class="form-group">
                                <label for="footer_instagram_title" class="font-weight-bold">Judul Galeri Footer</label>
                                <input type="text" id="footer_instagram_title" name="footer_instagram_title" class="form-control"
                                    value="<?php echo e($settings['footer_instagram_title'] ?? 'Instagram'); ?>">
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
                        <?php $__empty_1 = true; $__currentLoopData = $footer_galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" alt="gallery" class="img-thumbnail rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                </td>
                                <td class="align-middle">
                                    <?php if($gallery->link_url): ?>
                                        <a href="<?php echo e($gallery->link_url); ?>" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt mr-1"></i> <?php echo e(Str::limit($gallery->link_url, 50)); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted font-italic">- Tidak ada link -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editGalleryModal"
                                            data-id="<?php echo e($gallery->id); ?>" 
                                            data-link_url="<?php echo e($gallery->link_url); ?>"
                                            data-image_path="<?php echo e(asset('storage/' . $gallery->image_path)); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.footer-galleries.destroy', $gallery)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Belum ada gambar di galeri footer.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Gambar Galeri</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('admin.footer-galleries.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
      
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).ready(function () {
            
            $('#editGalleryModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);

                var form = $('#editGalleryForm');
                var actionUrl = '<?php echo e(url("admin/footer-galleries")); ?>/' + id;
                form.attr('action', actionUrl);

                modal.find('#edit_image_preview').attr('src', button.data('image_path'));
                modal.find('#edit_link_url').val(button.data('link_url'));
                
               
                modal.find('.custom-file-label').html('Pilih file baru...');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/footer/index.blade.php ENDPATH**/ ?>