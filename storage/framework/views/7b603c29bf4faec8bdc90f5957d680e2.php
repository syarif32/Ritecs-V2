

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Layanan HAKI</h1>

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
                <h6 class="m-0 font-weight-bold text-primary">Kelola Konten Intro HAKI</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.page.haki.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group"><label>Judul Utama</label><input type="text" name="haki_intro_title"
                            class="form-control" value="<?php echo e($haki_intro_title->value); ?>"></div>
                    <div class="form-group"><label>Subjudul</label><input type="text" name="haki_intro_subtitle"
                            class="form-control" value="<?php echo e($haki_intro_subtitle->value); ?>"></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="haki_intro_description"
                            class="form-control"><?php echo e($haki_intro_description->value); ?></textarea></div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan Konten Intro</button>
                </form>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Jenis Layanan HAKI</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addHakiTypeModal">Tambah Jenis</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ikon</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $haki_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><i class="<?php echo e($item->icon); ?>"></i></td>
                                <td><?php echo e($item->name); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editHakiTypeModal"
                                        data-item='<?php echo e($item->toJson()); ?>'>Edit</button>
                                    <form action="<?php echo e(route('admin.haki-types.destroy', $item)); ?>" method="POST"
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

        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kelola Paket Layanan HAKI</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addHakiPackageModal">Tambah Paket</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Harga Baru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $haki_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->title); ?></td>
                                <td>Rp. <?php echo e(number_format($item->new_price, 0, ',', '.')); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editHakiPackageModal" data-item='<?php echo e($item->toJson()); ?>'>Edit</button>
                                    <form action="<?php echo e(route('admin.haki-packages.destroy', $item)); ?>" method="POST"
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
    <!-- MODAL -->
    <div class="modal fade" id="addHakiTypeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis HAKI</h5>
                </div>
                <form action="<?php echo e(route('admin.haki-types.store')); ?>" method="POST">
                    <div class="modal-body"><?php echo csrf_field(); ?><div class="form-group"><label>Ikon (cth: fas fa-copyright)</label><input
                                type="text" name="icon" class="form-control" required></div>
                        <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control"
                                required></div>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editHakiTypeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jenis HAKI</h5>
                </div>
                <form method="POST">
                    <div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label>Ikon</label><input
                                type="text" name="icon" class="form-control" required></div>
                        <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control"
                                required></div>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addHakiPackageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Paket HAKI</h5>
                </div>
                <form action="<?php echo e(route('admin.haki-packages.store')); ?>" method="POST">
                    <div class="modal-body"><?php echo csrf_field(); ?><div class="form-group"><label>Judul Paket</label><input type="text"
                                name="title" class="form-control" required></div>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Harga Lama (Coret)</label><input type="number"
                                    name="old_price" class="form-control"></div>
                            <div class="form-group col-md-6"><label>Harga Baru</label><input type="number" name="new_price"
                                    class="form-control" required></div>
                        </div>
                        <div class="form-group"><label>Deskripsi Singkat (Opsional)</label><textarea name="description"
                                class="form-control"></textarea></div>
                        <div class="form-group"><label>Fitur (Pisahkan dengan koma)</label><textarea name="features"
                                class="form-control"></textarea></div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" placeholder="628xxxxxxxxxx"
                                required>
                            <small class="text-muted">Gunakan format 62, contoh: 6281234567890</small>
                        </div>


                        <div class="form-group"><label>Pesan WhatsApp</label><textarea name="whatsapp_message"
                                class="form-control" required></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editHakiPackageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Paket HAKI</h5>
                </div>
                <form method="POST">
                    <div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label>Judul Paket</label><input
                                type="text" name="title" class="form-control" required></div>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Harga Lama (Coret)</label><input type="number"
                                    name="old_price" class="form-control"></div>
                            <div class="form-group col-md-6"><label>Harga Baru</label><input type="number" name="new_price"
                                    class="form-control" required></div>
                        </div>
                        <div class="form-group"><label>Deskripsi Singkat (Opsional)</label><textarea name="description"
                                class="form-control"></textarea></div>
                        <div class="form-group"><label>Fitur (Pisahkan dengan koma)</label><textarea name="features"
                                class="form-control"></textarea></div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="whatsapp_number" class="form-control" placeholder="628xxxxxxxxxx"
                                required>
                            <small class="text-muted">Gunakan format 62, contoh: 6281234567890</small>
                        </div>

                        <div class="form-group"><label>Pesan WhatsApp</label><textarea name="whatsapp_message"
                                class="form-control" required></textarea></div>
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
            // Edit Haki 
            $('#editHakiTypeModal').on('show.bs.modal', function (e) {
                var item = $(e.relatedTarget).data('item');
                var form = $(this).find('form');
                form.attr('action', '<?php echo e(url("admin/haki-types")); ?>/' + item.id);
                form.find('[name="icon"]').val(item.icon);
                form.find('[name="name"]').val(item.name);
            });

            // Edit Haki 
            $('#editHakiPackageModal').on('show.bs.modal', function (e) {
                var item = $(e.relatedTarget).data('item');
                var form = $(this).find('form');
                form.attr('action', '<?php echo e(url("admin/haki-packages")); ?>/' + item.id);
                form.find('[name="title"]').val(item.title);
                form.find('[name="old_price"]').val(item.old_price);
                form.find('[name="new_price"]').val(item.new_price);
                form.find('[name="description"]').val(item.description);
                form.find('[name="whatsapp_number"]').val(item.whatsapp_number);
                form.find('[name="whatsapp_message"]').val(item.whatsapp_message);
                if (Array.isArray(item.features)) {
                    form.find('[name="features"]').val(item.features.join(', '));
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\haki\index.blade.php ENDPATH**/ ?>