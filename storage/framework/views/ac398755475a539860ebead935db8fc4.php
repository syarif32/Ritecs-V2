

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman Training Center</h1>
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
                <i class="fas fa-copyright mr-2"></i>Kelola Konten Kekayaan Intelektual (HAKI)
            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.training.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Utama</label>
                            <input type="text" name="training_haki_title" class="form-control" value="<?php echo e($haki_title->value); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Subjudul</label>
                            <input type="text" name="training_haki_subtitle" class="form-control" value="<?php echo e($haki_subtitle->value); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi</label>
                            <textarea name="training_haki_description" class="form-control" rows="4" required><?php echo e($haki_description->value); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Gambar Ilustrasi</label>
                            <div class="mb-2">
                                <?php if($haki_image->value): ?> 
                                    <img src="<?php echo e(asset('storage/' . $haki_image->value)); ?>" class="img-thumbnail rounded" style="max-height: 200px; width: auto;"> 
                                <?php else: ?>
                                    <div class="text-muted p-3 border rounded text-center">Tidak ada gambar</div>
                                <?php endif; ?>
                            </div>
                            <input type="file" name="training_haki_image" class="form-control-file mt-2">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Konten HAKI
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Daftar Program Pelatihan
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTrainingModal">
                <i class="fas fa-plus mr-1"></i> Tambah Program
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="15%" class="text-center">Gambar</th>
                            <th>Info Pelatihan</th>
                            <th>Jadwal & Harga</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" class="img-fluid rounded" style="max-height: 80px;">
                                </td>
                                <td class="align-middle">
                                    <h6 class="font-weight-bold text-dark mb-1"><?php echo e($item->title); ?></h6>
                                    <small class="text-muted d-block"><?php echo e(Str::limit($item->description, 80)); ?></small>
                                    <span class="badge badge-info mt-1"><i class="fas fa-user mr-1"></i> <?php echo e($item->contact_person); ?></span>
                                </td>
                                <td class="align-middle">
                                    <div class="small"><i class="far fa-calendar-alt mr-1"></i> <?php echo e($item->schedule); ?></div>
                                    <div class="font-weight-bold text-success"><i class="fas fa-tag mr-1"></i> <?php echo e($item->price); ?> <?php echo e($item->price_period); ?></div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editTrainingModal" 
                                            data-item='<?php echo e($item->toJson()); ?>'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.trainings.destroy', $item)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus program ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada data program pelatihan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-ul mr-2"></i>Layanan HAKI
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addHakiServiceModal">
                <i class="fas fa-plus mr-1"></i> Tambah Layanan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="10%" class="text-center">Ikon</th>
                            <th>Judul & Deskripsi</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $haki_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <i class="<?php echo e($item->icon); ?> fa-2x text-secondary"></i>
                                </td>
                                <td class="align-middle">
                                    <h6 class="font-weight-bold text-dark mb-1"><?php echo e($item->title); ?></h6>
                                    <small class="text-muted"><?php echo e($item->description); ?></small>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editHakiServiceModal" 
                                            data-item='<?php echo e($item->toJson()); ?>'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.haki-services.destroy', $item)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus layanan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Belum ada data layanan HAKI.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>




<div class="modal fade" id="addTrainingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Program Pelatihan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('admin.trainings.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Program</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jadwal</label>
                                <input type="text" name="schedule" class="form-control" placeholder="Contoh: Senin - Jumat" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" name="price" class="form-control" placeholder="Contoh: 750.000" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Periode Harga (Opsional)</label>
                                <input type="text" name="price_period" class="form-control" placeholder="Contoh: / orang">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Catatan Harga (Opsional)</label>
                        <input type="text" name="price_note" class="form-control" placeholder="Contoh: Diskon untuk grup > 5 orang">
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Narahubung</label>
                                <input type="text" name="contact_person" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor WhatsApp (62...)</label>
                                <input type="number" name="whatsapp_number" class="form-control" placeholder="Contoh: 628123456789" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teks Tombol</label>
                                <input type="text" name="button_text" class="form-control" value="Daftar Sekarang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar Banner</label>
                                <input type="file" name="image_path" class="form-control-file" required>
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


<div class="modal fade" id="editTrainingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Program Pelatihan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Program</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jadwal</label>
                                <input type="text" name="schedule" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Periode Harga</label>
                                <input type="text" name="price_period" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Catatan Harga</label>
                        <input type="text" name="price_note" class="form-control">
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Narahubung</label>
                                <input type="text" name="contact_person" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor WhatsApp (62...)</label>
                                <input type="number" name="whatsapp_number" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teks Tombol</label>
                                <input type="text" name="button_text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti Gambar (Opsional)</label>
                                <input type="file" name="image_path" class="form-control-file">
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




<div class="modal fade" id="addHakiServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Tambah Layanan HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('admin.haki-services.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Layanan</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas Ikon</label>
                        <input type="text" name="icon" class="form-control input-icon-target" placeholder="Contoh: fas fa-copyright" required>
                    </div>
                    
                    
                    <div class="form-group border rounded p-3 bg-light">
                        <label class="small text-uppercase font-weight-bold text-muted mb-2">Pilih Ikon (Klik untuk menggunakan)</label>
                        <div class="icon-reference-grid">
                            <?php $__currentLoopData = config('icons.font_awesome'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="icon-reference-item" onclick="selectIcon('<?php echo e($icon['class']); ?>')" title="<?php echo e($icon['class']); ?>">
                                <i class="<?php echo e($icon['class']); ?>"></i>
                                <span class="icon-class"><?php echo e(str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $icon['class'])); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
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


<div class="modal fade" id="editHakiServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Layanan HAKI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Layanan</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas Ikon</label>
                        <input type="text" name="icon" class="form-control input-icon-target" required>
                    </div>

                     
                     <div class="form-group border rounded p-3 bg-light">
                        <label class="small text-uppercase font-weight-bold text-muted mb-2">Pilih Ikon (Klik untuk mengganti)</label>
                        <div class="icon-reference-grid">
                            <?php $__currentLoopData = config('icons.font_awesome'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="icon-reference-item" onclick="selectIcon('<?php echo e($icon['class']); ?>')" title="<?php echo e($icon['class']); ?>">
                                <i class="<?php echo e($icon['class']); ?>"></i>
                                <span class="icon-class"><?php echo e(str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $icon['class'])); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
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

<?php $__env->startPush('styles'); ?>
<style>
    /* Styling Grid Ikon Rapi (Sama dengan Membership) */
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi Helper: Pilih Ikon saat diklik di dalam Modal
    function selectIcon(iconClass) {
        var activeModal = $('.modal.show');
        if (activeModal.length) {
            activeModal.find('.input-icon-target').val(iconClass);
        }
    }

    $(document).ready(function () {
        // Logic Modal Edit Training 
        $('#editTrainingModal').on('show.bs.modal', function (e) {
            var item = $(e.relatedTarget).data('item');
            var form = $(this).find('form');
            
            // Set Action URL
            form.attr('action', '<?php echo e(url("admin/trainings")); ?>/' + item.id);
            
            // Populate Fields
            form.find('[name="title"]').val(item.title);
            form.find('[name="description"]').val(item.description);
            form.find('[name="schedule"]').val(item.schedule);
            form.find('[name="contact_person"]').val(item.contact_person);
            form.find('[name="whatsapp_number"]').val(item.whatsapp_number); // Fix: Added whatsapp_number
            form.find('[name="price"]').val(item.price);
            form.find('[name="price_period"]').val(item.price_period);
            form.find('[name="price_note"]').val(item.price_note);
            form.find('[name="button_text"]').val(item.button_text);
        });

        // Logic Modal Edit Haki 
        $('#editHakiServiceModal').on('show.bs.modal', function (e) {
            var item = $(e.relatedTarget).data('item');
            var form = $(this).find('form');
            
            // Set Action URL
            form.attr('action', '<?php echo e(url("admin/haki-services")); ?>/' + item.id);
            
            // Populate Fields
            form.find('[name="icon"]').val(item.icon);
            form.find('[name="title"]').val(item.title);
            form.find('[name="description"]').val(item.description);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/training/index.blade.php ENDPATH**/ ?>