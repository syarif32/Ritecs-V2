<?php $__env->startSection('content'); ?>


<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Layanan HAKI</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layanan</a></li>
            <li class="breadcrumb-item active text-primary">HAKI</li>
        </ol>    
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary"><?php echo e($haki_intro_title->value ?? 'Tentang HAKI'); ?></h4>
            <h1 class="display-4 mb-4"><?php echo e($haki_intro_subtitle->value ?? 'Pentingnya Hak Atas Kekayaan Intelektual'); ?></h1>
            <p class="lead text-muted px-3"><?php echo e($haki_intro_description->value ?? 'Deskripsi HAKI belum diatur.'); ?></p>
        </div>
    </div>
</div>

<div class="container-fluid feature bg-light py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Cakupan Layanan</h4>
            <h1 class="display-5 mb-4">Jenis Kekayaan Intelektual yang Kami Tangani</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <?php $__empty_1 = true; $__currentLoopData = $haki_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="book-type-card h-100">
                    <div class="icon-container"><i class="<?php echo e($type->icon); ?>"></i></div>
                    <h5 class="book-title"><?php echo e($type->name); ?></h5>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">Jenis layanan HAKI akan segera diumumkan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Investasi Layanan</h4>
            <h1 class="display-4 mb-5">Paket Layanan HAKI</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <?php $__empty_1 = true; $__currentLoopData = $haki_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="pricing-card h-100" style="box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header text-center"><h4 class="card-title text-dark"><?php echo e($package->title); ?></h4></div>
                    <div class="card-body text-center p-4">
                        <div class="price-tag mb-4">
                            <?php if($package->old_price): ?>
                            <s class="text-muted fs-5">Rp. <?php echo e(number_format($package->old_price, 0, ',', '.')); ?></s>
                            <?php endif; ?>
                            <h2 class="display-5 fw-bold text-primary mb-0">Rp. <?php echo e(number_format($package->new_price, 0, ',', '.')); ?></h2>
                        </div>
                        <?php if($package->description): ?>
                        <p class="text-muted px-3"><?php echo e($package->description); ?></p>
                        <?php endif; ?>
                        <?php if(!empty($package->features)): ?>
                        <ul class="list-group list-group-flush text-start mb-4">
                            <?php $__currentLoopData = $package->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item"><i class="fa fa-check text-primary me-2"></i><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-4">
                        <a href="https://wa.me/6281390920585?text=<?php echo e(urlencode($package->whatsapp_message)); ?>" class="btn btn-success rounded-pill py-2 px-4 w-100" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">Paket layanan HAKI akan segera diumumkan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/haki.blade.php ENDPATH**/ ?>