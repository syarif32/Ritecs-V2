<?php $__env->startSection('content'); ?>

    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?php echo e(ucfirst($title ?? 'Ritecs')); ?>

            </h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Layanan</a></li>
                <li class="breadcrumb-item active text-primary">Journal</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid py-5" id="ircs-journal">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 2rem;">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Navigasi Cepat</h5>
                            <div class="sidebar-nav">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tujuan"><i class="fas fa-bullseye me-2"></i>Tujuan & Ruang Lingkup</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#layanan-jurnal"><i class="fas fa-book me-2"></i>Layanan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="ircs-section" id="tujuan">
                        <h3 class="mb-3">Tujuan & Ruang Lingkup</h3>
                        
                        <p><?php echo nl2br(e($aim_scope_text)); ?></p>
                        
                        <ul class="topic-list mt-4">
                            <?php $__empty_1 = true; $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li><?php echo e($scope->name); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li>Daftar ruang lingkup belum ditambahkan dari halaman admin.</li>
                            <?php endif; ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-0 pb-5" id="layanan-jurnal">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                <h1 class="display-5 mb-3">Layanan Publikasi Jurnal</h1>
                <p class="lead text-muted">
                    Kami menyediakan platform yang efisien dan terpercaya untuk publikasi karya ilmiah Anda. Dengan proses yang cepat dan dukungan penuh, kami membantu menyebarkan penelitian Anda ke audiens yang lebih luas.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item h-100 p-4 text-center border-0 shadow-sm rounded">
                            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary text-white p-3 rounded-circle mb-4">
                                <i class="<?php echo e($service->icon); ?> fa-2x"></i>
                            </div>
                            <h4 class="mb-3"><?php echo e($service->title); ?></h4>
                            <p class="mb-0">
                                <?php echo e($service->description); ?>

                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <p class="text-muted lead">Layanan publikasi jurnal akan segera tersedia. Silakan periksa kembali nanti.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.5s">
            <a href="<?php echo e(route('journal')); ?>" class="btn btn-primary btn-lg rounded-pill py-3 px-5">
                <i class="fas fa-arrow-right me-2"></i> Kunjungi Halaman Jurnal Kami
            </a>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/ircs-journal.blade.php ENDPATH**/ ?>