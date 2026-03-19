<?php
    $icons = [
        ['class' => 'fas fa-book'], ['class' => 'fas fa-book-open'], ['class' => 'fas fa-atlas'],
        ['class' => 'fas fa-file-alt'], ['class' => 'fas fa-file-signature'], ['class' => 'fas fa-newspaper'],
        ['class' => 'fas fa-pen-nib'], ['class' => 'fas fa-pencil-alt'], ['class' => 'fas fa-edit'],
        ['class' => 'fas fa-users'], ['class' => 'fas fa-user-graduate'], ['class' => 'fas fa-user-friends'],
        ['class' => 'fas fa-globe'], ['class' => 'fas fa-globe-asia'], ['class' => 'fas fa-language'],
        ['class' => 'fas fa-search'], ['class' => 'fas fa-search-plus'], ['class' => 'fas fa-check-circle'],
        ['class' => 'fas fa-star'], ['class' => 'fas fa-award'], ['class' => 'fas fa-medal'],
        ['class' => 'fas fa-copyright'], ['class' => 'fas fa-balance-scale'], ['class' => 'fas fa-gavel'],
        ['class' => 'fas fa-laptop-code'], ['class' => 'fas fa-code'], ['class' => 'fas fa-database'],
        ['class' => 'fe fe-book'], ['class' => 'fe fe-book-open'], ['class' => 'fe fe-file-text'],
        ['class' => 'fe fe-edit'], ['class' => 'fe fe-edit-2'], ['class' => 'fe fe-edit-3'],
        ['class' => 'fe fe-users'], ['class' => 'fe fe-user-check'], ['class' => 'fe fe-globe'],
        ['class' => 'fe fe-search'], ['class' => 'fe fe-check-circle'], ['class' => 'fe fe-check-square'],
        ['class' => 'fe fe-star'], ['class' => 'fe fe-award'], ['class' => 'fe fe-shield']
    ];
?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="page-title">Kelola Halaman Layanan Jurnal</h2>
            <p class="text-muted">Atur teks tujuan, topik ruang lingkup, dan kartu layanan publikasi.</p>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fe fe-check-circle mr-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-align-left mr-2"></i>Teks Tujuan & Ruang Lingkup</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.page.journal-service.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="small text-muted text-uppercase">Paragraf Utama</label>
                            <textarea name="journal_aim_scope_text" class="form-control" rows="4" required><?php echo e($aim_scope->value); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save mr-1"></i> Simpan Paragraf
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        
        <div class="col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-target mr-2"></i>Topik Ruang Lingkup</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addScopeModal">
                        <i class="fe fe-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Topik</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="align-middle font-weight-bold"><?php echo e($scope->name); ?></td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                data-toggle="modal" data-target="#editScopeModal" 
                                                data-id="<?php echo e($scope->id); ?>" data-name="<?php echo e($scope->name); ?>">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.scopes.destroy', $scope)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus topik ini?')">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($scopes->isEmpty()): ?>
                                <tr><td colspan="2" class="text-center py-3 text-muted">Belum ada data topik.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fe fe-grid mr-2"></i>Kartu Layanan</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addServiceModal">
                        <i class="fe fe-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%" class="text-center">Ikon</th>
                                    <th>Judul & Deskripsi</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <i class="<?php echo e($service->icon); ?> fa-lg text-info"></i>
                                    </td>
                                    <td class="align-middle">
                                        <span class="d-block font-weight-bold text-dark"><?php echo e($service->title); ?></span>
                                        <small class="text-muted"><?php echo e(Str::limit($service->description, 60)); ?></small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                data-toggle="modal" data-target="#editServiceModal"
                                                data-id="<?php echo e($service->id); ?>" 
                                                data-icon="<?php echo e($service->icon); ?>" 
                                                data-title="<?php echo e($service->title); ?>" 
                                                data-description="<?php echo e($service->description); ?>">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus layanan ini?')">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($services->isEmpty()): ?>
                                <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada data layanan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="modal fade" id="addScopeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Topik</h5></div>
            <form action="<?php echo e(route('admin.scopes.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Topik</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Computer Science" required>
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


<div class="modal fade" id="editScopeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Topik</h5></div>
            <form id="editScopeForm" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Topik</label>
                        <input type="text" id="edit_scope_name" name="name" class="form-control" required>
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


<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Layanan</h5></div>
            <form action="<?php echo e(route('admin.services.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Layanan</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas Ikon</label>
                                <input type="text" name="icon" class="form-control" placeholder="fas fa-book" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    
                    <div class="form-group mt-3">
                        <label class="small text-muted text-uppercase mb-2">Referensi Ikon (Klik untuk copy)</label>
                        <div class="icon-reference-grid border rounded p-2 bg-light">
                            <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="icon-reference-item" onclick="copyIcon('<?php echo e($icon['class']); ?>')">
                                <i class="<?php echo e($icon['class']); ?> fa-lg"></i>
                                <span class="icon-class"><?php echo e($icon['class']); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


<div class="modal fade" id="editServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Layanan</h5></div>
            <form id="editServiceForm" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Layanan</label>
                                <input type="text" id="edit_service_title" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas Ikon</label>
                                <input type="text" id="edit_service_icon" name="icon" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="edit_service_description" name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    
                    <div class="form-group mt-3">
                        <label class="small text-muted text-uppercase mb-2">Referensi Ikon (Klik untuk copy)</label>
                        <div class="icon-reference-grid border rounded p-2 bg-light">
                            <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="icon-reference-item" onclick="copyIcon('<?php echo e($icon['class']); ?>')">
                                <i class="<?php echo e($icon['class']); ?> fa-lg"></i>
                                <span class="icon-class"><?php echo e($icon['class']); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .icon-reference-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 8px;
        max-height: 250px; /* Scrollable inside modal */
        overflow-y: auto;
    }
    .icon-reference-item {
        display: flex;
        align-items: center;
        gap: 10px; 
        padding: 6px 10px;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .icon-reference-item:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
    .icon-reference-item i {
        width: 20px; text-align: center; color: #4e73df; 
    }
    .icon-reference-item .icon-class {
        font-family: monospace; font-size: 0.85em; color: #495057;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi Copy Ikon Sederhana
    function copyIcon(text) {
        // Coba cari input icon yang sedang aktif (terbuka di modal)
        if ($('#addServiceModal').hasClass('show')) {
            $('input[name="icon"]').val(text);
        } else if ($('#editServiceModal').hasClass('show')) {
            $('#edit_service_icon').val(text);
        }
        // Opsional: Copy ke clipboard browser
        navigator.clipboard.writeText(text);
        alert('Ikon ' + text + ' berhasil disalin ke kolom input!');
    }

    $(document).ready(function() {
        
        // 1. Logic Modal Edit Scope
        $('#editScopeModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            
            // Set Value
            $('#edit_scope_name').val(name);
            
            // Set Action Form URL secara manual sesuai pola route resource
            var actionUrl = '<?php echo e(url("admin/scopes")); ?>/' + id;
            $('#editScopeForm').attr('action', actionUrl);
        });

        // 2. Logic Modal Edit Service
        $('#editServiceModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var icon = button.data('icon');
            var title = button.data('title');
            var description = button.data('description');

            // Set Values
            $('#edit_service_icon').val(icon);
            $('#edit_service_title').val(title);
            $('#edit_service_description').val(description);

            // Set Action Form URL
            var actionUrl = '<?php echo e(url("admin/services")); ?>/' + id;
            $('#editServiceForm').attr('action', actionUrl);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/layanan-jurnal/index.blade.php ENDPATH**/ ?>