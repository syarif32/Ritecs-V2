<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo e(isset($service) ? 'Edit' : 'Tambah'); ?> Layanan</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?php echo e(isset($service) ? route('admin.services.update', $service) : route('admin.services.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(isset($service)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                <div class="form-group">
                    <label for="icon">Ikon</label>
                    <input type="text" id="icon" name="icon" class="form-control" value="<?php echo e(old('icon', $service->icon ?? '')); ?>" required>
                    <small class="form-text text-muted">Ketik manual nama kelas ikon dari referensi di bawah (contoh: `fas fa-unlock`).</small>
                </div>
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo e(old('title', $service->title ?? '')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" required><?php echo e(old('description', $service->description ?? '')); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('admin.page.journal-service.index')); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Referensi Ikon</h6>
        </div>
        <div class="card-body">
            <div class="icon-reference-grid">
                <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="icon-reference-item">
                    
                    <i class="<?php echo e($icon['class']); ?> fa-lg"></i>
                    
                    <span class="icon-class"><?php echo e($icon['class']); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>


<style>
    .icon-reference-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 10px;
        max-height: 400px;
        overflow-y: auto;
    }
    .icon-reference-item {
        display: flex;
        align-items: center;
        gap: 15px; 
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
    .icon-reference-item i {
        width: 20px; 
        text-align: center;
        color: #0d6efd; 
    }
    .icon-reference-item .icon-class {
        font-family: monospace; 
        font-size: 0.9em;
        color: #495057;
    }
</style>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\layanan-jurnal\services.blade.php ENDPATH**/ ?>