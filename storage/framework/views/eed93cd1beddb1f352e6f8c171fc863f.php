<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Informasi Kontak</h1>
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
            <i class="fas fa-check-circle mr-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.page.contact.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            
            
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-address-card mr-2"></i>Detail Kontak
                        </h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Alamat Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <textarea id="contact_address" name="contact_address" class="form-control" rows="3" required><?php echo e($address->value); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" id="contact_email" name="contact_email" class="form-control" value="<?php echo e($email->value); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Telepon / WhatsApp</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?php echo e($phone->value); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Situs Web</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="text" id="contact_site" name="contact_site" class="form-control" value="<?php echo e($site->value); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

         
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-map-marked-alt mr-2"></i>Google Maps Embed
                        </h6>
                    </div>
                    <div class="card-body">
                        
                       
                        <div class="form-group">
                            <label class="small text-uppercase font-weight-bold text-muted">Preview Lokasi</label>
                            <div class="embed-responsive embed-responsive-16by9 border rounded bg-light">
                                <iframe class="embed-responsive-item" id="map_preview" src="<?php echo e($map_link->value); ?>" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Link Embed (Src URL)</label>
                            <textarea id="contact_map_link" name="contact_map_link" class="form-control" rows="3" required placeholder="https://www.google.com/maps/embed?pb=..."><?php echo e($map_link->value); ?></textarea>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Cara ambil link: Buka Google Maps > Share > Embed a map > Copy HTML. 
                                <br><strong>Ambil hanya URL di dalam tanda kutip <code>src="..."</code>.</strong>
                            </small>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body d-flex justify-content-end align-items-center">
                        <span class="text-muted mr-3 small">Pastikan data sudah benar sebelum menyimpan.</span>
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
   
    document.getElementById('contact_map_link').addEventListener('input', function() {
        var url = this.value;
        var iframe = document.getElementById('map_preview');
        
        
        if (url.includes('<iframe')) {
            var match = url.match(/src="([^"]+)"/);
            if (match) {
                url = match[1];
             
                this.value = url; 
            }
        }
        
        iframe.src = url;
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/contact/index.blade.php ENDPATH**/ ?>