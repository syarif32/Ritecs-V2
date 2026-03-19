

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Training Center</h1>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Konten Kekayaan Intelektual (HAKI)</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.page.training.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group"><label>Judul Utama</label><input type="text" name="training_haki_title"
                            class="form-control" value="<?php echo e($haki_title->value); ?>"></div>
                    <div class="form-group"><label>Subjudul</label><input type="text" name="training_haki_subtitle"
                            class="form-control" value="<?php echo e($haki_subtitle->value); ?>"></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="training_haki_description"
                            class="form-control"><?php echo e($haki_description->value); ?></textarea></div>
                    <div class="form-group"><label>Gambar (Ganti)</label><input type="file" name="training_haki_image"
                            class="form-control"></div>
                    <?php if($haki_image->value): ?> <img src="<?php echo e(asset('storage/' . $haki_image->value)); ?>" class="img-thumbnail"
                    width="200"> <?php endif; ?>
                    <button type="submit" class="btn btn-primary mt-3">Simpan Konten HAKI</button>
                </form>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Program Pelatihan</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addTrainingModal">Tambah Program</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" width="100" class="img-thumbnail">
                                </td>
                                <td><?php echo e($item->title); ?></td>
                                <td><?php echo e($item->schedule); ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editTrainingModal" data-item='<?php echo e($item->toJson()); ?>'>Edit</button>
                                    <form action="<?php echo e(route('admin.trainings.destroy', $item)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Layanan HAKI</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addHakiServiceModal">Tambah Layanan</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ikon</th>
                            <th>Judul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $haki_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><i class="<?php echo e($item->icon); ?>"></i></td>
                                <td><?php echo e($item->title); ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editHakiServiceModal" data-item='<?php echo e($item->toJson()); ?>'>Edit</button>
                                    <form action="<?php echo e(route('admin.haki-services.destroy', $item)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="addTrainingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Program Pelatihan</h5>
                </div>
                <form action="<?php echo e(route('admin.trainings.store')); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <div class="form-group"><label>Judul</label><input type="text" name="title" class="form-control"
                                required></div>
                        <div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control"
                                required></textarea></div>
                        <div class="form-group"><label>Gambar</label><input type="file" name="image_path"
                                class="form-control" required></div>
                        <div class="form-group"><label>Jadwal</label><input type="text" name="schedule" class="form-control"
                                required></div>
                        <div class="form-group"><label>Narahubung</label><input type="text" name="contact_person"
                                class="form-control" required></div>
                        <div class="form-group"><label>Harga</label><input type="text" name="price" class="form-control"
                                required placeholder="cth: Rp 750.000 atau Hubungi Kami"></div>
                        <div class="form-group"><label>Periode Harga (Opsional)</label><input type="text"
                                name="price_period" class="form-control" placeholder="cth: / orang"></div>
                        <div class="form-group"><label>Catatan Harga (Opsional)</label><input type="text" name="price_note"
                                class="form-control" placeholder="cth: Paket kelompok tersedia"></div>
                        <div class="form-group"><label>Teks Tombol</label><input type="text" name="button_text"
                                class="form-control" value="Daftar Sekarang" required></div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" required
                                placeholder="cth: 6281234567890">
                            <small class="text-muted">
                                Harus diawali 62. Contoh: 6281234567890
                            </small>
                        </div>

                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editTrainingModal" tabindex="-1">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Program Pelatihan</h5>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label>Judul</label><input
                                type="text" name="title" class="form-control" required></div>
                        <div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control"
                                required></textarea></div>
                        <div class="form-group"><label>Gambar Baru (Opsional)</label><input type="file" name="image_path"
                                class="form-control"></div>
                        <div class="form-group"><label>Jadwal</label><input type="text" name="schedule" class="form-control"
                                required></div>
                        <div class="form-group"><label>Narahubung</label><input type="text" name="contact_person"
                                class="form-control" required></div>
                        <div class="form-group"><label>Harga</label><input type="text" name="price" class="form-control"
                                required></div>
                        <div class="form-group"><label>Periode Harga</label><input type="text" name="price_period"
                                class="form-control"></div>
                        <div class="form-group"><label>Catatan Harga</label><input type="text" name="price_note"
                                class="form-control"></div>
                        <div class="form-group"><label>Teks Tombol</label><input type="text" name="button_text"
                                class="form-control" required></div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" required
                                placeholder="cth: 6281234567890">
                            <small class="text-muted">
                                Harus diawali 62. Contoh: 6281234567890
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addHakiServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Layanan HAKI</h5>
                </div>
                <form action="<?php echo e(route('admin.haki-services.store')); ?>" method="POST">
                    <div class="modal-body"><?php echo csrf_field(); ?><div class="form-group"><label>Ikon (cth: fas fa-copyright)</label><input
                                type="text" name="icon" class="form-control" required></div>
                        <div class="form-group"><label>Judul</label><input type="text" name="title" class="form-control"
                                required></div>
                        <div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control"
                                required></textarea></div>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editHakiServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Layanan HAKI</h5>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group">
                            <label>Ikon (cth: fas fa-copyright)</label>
                            <input type="text" name="icon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
        $(document).ready(function () {
            // Edit Training 
            $('#editTrainingModal').on('show.bs.modal', function (e) {
                var item = $(e.relatedTarget).data('item');
                var form = $(this).find('form');
                form.attr('action', '<?php echo e(url("admin/trainings")); ?>/' + item.id);
                form.find('[name="title"]').val(item.title);
                form.find('[name="description"]').val(item.description);
                form.find('[name="schedule"]').val(item.schedule);
                form.find('[name="contact_person"]').val(item.contact_person);
                form.find('[name="price"]').val(item.price);
                form.find('[name="price_period"]').val(item.price_period);
                form.find('[name="price_note"]').val(item.price_note);
                form.find('[name="button_text"]').val(item.button_text);
                form.find('[name="button_url"]').val(item.button_url);
            });

            // Edit Haki 
            $('#editHakiServiceModal').on('show.bs.modal', function (e) {
                var item = $(e.relatedTarget).data('item');
                var form = $(this).find('form');
                form.attr('action', '<?php echo e(url("admin/haki-services")); ?>/' + item.id);
                form.find('[name="icon"]').val(item.icon);
                form.find('[name="title"]').val(item.title);
                form.find('[name="description"]').val(item.description);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\training\index.blade.php ENDPATH**/ ?>