<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Kelola Konten Footer</h1>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div><?php endif; ?>
        <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div><?php endif; ?>

        
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Info Kontak, Sosial Media & Judul Galeri</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.page.footer.updateSettings')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group"><label>Alamat</label><textarea name="contact_address" class="form-control"
                            rows="3"><?php echo e($settings['contact_address'] ?? ''); ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group col-md-6"><label>Email</label><input type="email" name="contact_email"
                                class="form-control" value="<?php echo e($settings['contact_email'] ?? ''); ?>"></div>
                        <div class="form-group col-md-6"><label>Telepon</label><input type="text" name="contact_phone"
                                class="form-control" value="<?php echo e($settings['contact_phone'] ?? ''); ?>"></div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6"><label>Link Facebook</label><input type="url"
                                name="social_facebook" class="form-control"
                                value="<?php echo e($settings['social_facebook'] ?? ''); ?>"></div>
                        <div class="form-group col-md-6"><label>Link Twitter</label><input type="url" name="social_twitter"
                                class="form-control" value="<?php echo e($settings['social_twitter'] ?? ''); ?>"></div>
                        <div class="form-group col-md-6"><label>Link Instagram</label><input type="url"
                                name="social_instagram" class="form-control"
                                value="<?php echo e($settings['social_instagram'] ?? ''); ?>"></div>
                        <div class="form-group col-md-6"><label>Link LinkedIn</label><input type="url"
                                name="social_linkedin" class="form-control"
                                value="<?php echo e($settings['social_linkedin'] ?? ''); ?>"></div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="footer_instagram_title">Judul Galeri Instagram</label>
                        <input type="text" id="footer_instagram_title" name="footer_instagram_title" class="form-control"
                            value="<?php echo e($settings['footer_instagram_title'] ?? 'Instagram'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Gambar </h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addGalleryModal">Tambah Gambar</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Link URL</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $footer_galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" alt="gallery" width="80"></td>
                                <td><a href="<?php echo e($gallery->link_url); ?>" target="_blank"><?php echo e($gallery->link_url); ?></a></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editGalleryModal"
                                        data-id="<?php echo e($gallery->id); ?>" data-link_url="<?php echo e($gallery->link_url); ?>"
                                        data-image_path="<?php echo e(asset('storage/' . $gallery->image_path)); ?>">Edit</button>
                                    <form action="<?php echo e(route('admin.footer-galleries.destroy', $gallery)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada gambar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addGalleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gambar Galeri</h5>
                </div>
                <form action="<?php echo e(route('admin.footer-galleries.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group"><label>Upload Gambar</label><input type="file" name="image_path"
                                class="form-control" required></div>
                        <div class="form-group"><label>Link URL (Opsional)</label><input type="url" name="link_url"
                                class="form-control" placeholder="https://instagram.com/p/..."></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGalleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gambar Galeri</h5>
                </div>
                <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="form-group"><label>Gambar Saat Ini:</label><br><img id="edit_image_preview" src=""
                                alt="preview" width="120" class="rounded"></div>
                        <div class="form-group"><label>Upload Gambar Baru (Kosongkan jika tidak ganti)</label><input
                                type="file" name="image_path" class="form-control"></div>
                        <div class="form-group"><label>Link URL (Opsional)</label><input type="url" id="edit_link_url"
                                name="link_url" class="form-control"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            $('#editGalleryModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                var form = $('#editGalleryForm');
                var actionUrl = '<?php echo e(url("admin/footer-galleries")); ?>/' + id;
                form.attr('action', actionUrl);

                form.find('#edit_image_preview').attr('src', button.data('image_path'));
                form.find('#edit_link_url').val(button.data('link_url'));
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\footer\index.blade.php ENDPATH**/ ?>