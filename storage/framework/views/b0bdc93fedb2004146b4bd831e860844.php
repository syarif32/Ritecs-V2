<?php $__env->startSection('content'); ?>


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Layanan Jurnal</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow mb-4">
        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Tujuan & Ruang Lingkup (Paragraf Utama)</h6></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.journal-service.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <textarea name="journal_aim_scope_text" class="form-control" rows="5" required><?php echo e($aim_scope->value); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Paragraf</button>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Topik Ruang Lingkup</h6>
            <a href="<?php echo e(route('admin.scopes.create')); ?>" class="btn btn-primary btn-sm">Tambah Topik</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Nama Topik</th><th width="15%">Aksi</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($scope->name); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.scopes.edit', $scope)); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?php echo e(route('admin.scopes.destroy', $scope)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kartu Layanan</h6>
            <a href="<?php echo e(route('admin.services.create')); ?>" class="btn btn-primary btn-sm">Tambah Layanan</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                 <thead><tr><th>Ikon</th><th>Judul</th><th>Deskripsi</th><th width="15%">Aksi</th></tr></thead>
                 <tbody>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><i class="<?php echo e($service->icon); ?>"></i></td>
                        <td><?php echo e($service->title); ?></td>
                        <td><?php echo e(Str::limit($service->description, 50)); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\layanan-jurnal\index.blade.php ENDPATH**/ ?>