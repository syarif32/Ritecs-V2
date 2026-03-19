<?php $__env->startSection('content'); ?>

    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.2s">Petunjuk Penulis</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Bantuan</a></li>
                <li class="breadcrumb-item active text-primary">Petunjuk Penulis</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid feature bg-light py-5">
        <div class="container-fluid py-5" id="petunjuk-penulis">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h1 class="display-6 mb-3"><?php echo e($book_types_title->value ?? 'Menerbitkan Buku Bersama Ritecs'); ?></h1>
                    <p><?php echo e($book_types_subtitle->value ?? 'Kami menerima beragam jenis naskah...'); ?></p>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php $__empty_1 = true; $__currentLoopData = $book_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                            <a href="#" class="text-decoration-none">
                                <div class="book-type-card">
                                    <div class="icon-container"><i class="<?php echo e($book_type->icon); ?>"></i></div>
                                    <h6 class="book-title"><?php echo e($book_type->name); ?></h6>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center">Jenis buku belum diatur.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h4 class="text-primary">Model Publikasi</h4>
                <h1 class="display-6 mb-4"><?php echo e($schemes_title->value ?? 'Skema Penerbitan Buku'); ?></h1>
                <p><?php echo e($schemes_subtitle->value ?? 'Pilih skema penerbitan yang paling sesuai...'); ?></p>
            </div>
            <div class="row g-4 justify-content-center">
                <?php $__empty_1 = true; $__currentLoopData = $publishing_schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="scheme-card">
                            <div class="icon-container"><i class="<?php echo e($scheme->icon); ?>"></i></div>
                            <h5 class="fw-bold text-dark mt-0"><?php echo e($scheme->title); ?></h5>
                            <p class="mb-2"><?php echo e($scheme->description); ?></p>
                            <div class="text-primary fw-medium"><i class="fas fa-check-circle me-1"></i> <?php echo e($scheme->feature); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                     <p class="text-center">Skema penerbitan belum diatur.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-md-5 pb-3 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Langkah & Tahap</h4>
                <h1 class="display-4 mb-4"><?php echo e($steps_title->value ?? 'Prosedur Penerbitan Buku'); ?></h1>
                <p class="mb-0"><?php echo e($steps_subtitle->value ?? 'Ikuti prosedur berikut...'); ?></p>
            </div>
            <div class="row">
                <div class="col col-12 col-xl-5 p-0 d-none d-xl-block wow fadeInUp" data-wow-delay="0.2s">
                    <div class="d-flex justify-content-center align-items-center h-100 p-3 p-md-5 ps-3 ps-md-0 pb-3 pb-md-0">
                        <img src="<?php echo e(asset('assets/img/petunjuk2.webp')); ?>" class="img-fluid img-petunjuk" alt="">
                    </div>
                </div>
                <div class="col col-12 col-xl-7">
                    <div class="timeline">
                        <?php $__empty_1 = true; $__currentLoopData = $publishing_steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="timeline-item wow fadeInUp" data-wow-delay="0.2s">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content rounded">
                                    <h5 class="m-0 p-0 mb-1"><?php echo e($step->title); ?></h5>
                                    <p class="p-0 m-0"><?php echo nl2br(e($step->description)); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-center">Prosedur penerbitan belum diatur.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/petunjuk-penulis.blade.php ENDPATH**/ ?>