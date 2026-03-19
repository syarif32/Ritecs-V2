<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo e(isset($scope) ? 'Edit' : 'Tambah'); ?> Topik Ruang Lingkup</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="<?php echo e(isset($scope) ? route('admin.scopes.update', $scope) : route('admin.scopes.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(isset($scope)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Nama Topik</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $scope->name ?? '')); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('admin.page.journal-service.index')); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\layanan-jurnal\scopes.blade.php ENDPATH**/ ?>