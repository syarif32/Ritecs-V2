<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Kelola Informasi Kontak</h1>

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
                <h6 class="m-0 font-weight-bold text-primary">Data Kontak & Peta Lokasi</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.page.contact.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="contact_address">Alamat</label>
                        <textarea id="contact_address" name="contact_address" class="form-control" rows="3"
                            required><?php echo e($address->value); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-control"
                            value="<?php echo e($email->value); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Telepon</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="form-control"
                            value="<?php echo e($phone->value); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_site">Situs</label>
                        <input type="text" id="contact_site" name="contact_site" class="form-control"
                            value="<?php echo e($site->value); ?>" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="contact_map_link">Link Google Maps Embed</label>
                        <textarea id="contact_map_link" name="contact_map_link" class="form-control" rows="5"
                            required><?php echo e($map_link->value); ?></textarea>
                        <small class="form-text text-muted">Buka Google Maps, cari lokasi Anda, klik "Share", pilih "Embed a
                            map", lalu salin URL yang ada di dalam `src="..."`.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\contact\index.blade.php ENDPATH**/ ?>