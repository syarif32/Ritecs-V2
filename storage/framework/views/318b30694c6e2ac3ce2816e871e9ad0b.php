<?php $__env->startSection('content'); ?>


<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Program Keanggotaan</h1>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layanan</a></li>
            <li class="breadcrumb-item active text-primary">Membership</li>
        </ol>    
    </div>
</div>


<div class="container-fluid bg-light py-5" id="membership">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Pilih Paket yang Tepat Untuk Anda</h2>
            <p class="lead text-muted">Kami menawarkan berbagai level keanggotaan dengan benefit eksklusif untuk mendukung kebutuhan Anda. Bergabunglah dengan komunitas kami sekarang.</p>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="pricing-card popular h-100">
                    <div class="card-header text-center"><h4 class="card-title">Membership</h4></div>
                    <div class="card-body text-center">
                        <div class="price-tag">
                            <sup>Rp</sup><span class="display-4"><?php echo e($price); ?></span><span class="text-muted">/Tahun</span>
                        </div>
                        <p class="mt-2"><?php echo e($price_description); ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php $__empty_2 = true; $__currentLoopData = $featured_benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <li class="list-group-item"><i class="fas fa-check-circle me-2"></i><?php echo e($benefit->title); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <li class="list-group-item">Keuntungan utama belum diatur.</li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-primary rounded-pill w-100">Pilih Paket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Keuntungan Menjadi Anggota</h2>
            <p class="lead text-muted">Dapatkan akses ke sumber daya berkualitas yang akan meningkatkan pengetahuan dan keahlian Anda secara signifikan.</p>
        </div>
        <div class="row g-4">
            <?php $__empty_2 = true; $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="<?php echo e($benefit->icon); ?> fa-2x"></i></div>
                        <h5 class="mb-2"><?php echo e($benefit->title); ?></h5>
                        <p class="text-muted"><?php echo e($benefit->description); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <p class="text-center">Keuntungan menjadi anggota akan segera diumumkan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h2 class="display-5 mb-3">Pertanyaan Umum</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion skema-accordion wow fadeInUp" data-wow-delay="0.3s" id="faqAccordion">
                    <?php $__empty_2 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading<?php echo e($loop->iteration); ?>">
                                <button class="accordion-button <?php echo e($loop->first ? '' : 'collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo e($loop->iteration); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                    <?php echo e($faq->question); ?>

                                </button>
                            </h2>
                            <div id="faqCollapse<?php echo e($loop->iteration); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?php echo nl2br(e($faq->answer)); ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <p class="text-center">Belum ada pertanyaan umum yang ditambahkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container py-5">
        <div class="text-center bg-primary rounded-3 p-5 wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="text-white display-5 mb-3">Siap Bergabung?</h2>
            <p class="text-white-50 mb-4">Tingkatkan keahlian Anda ke level berikutnya. Daftar sekarang dan nikmati semua benefit eksklusif yang kami tawarkan.</p>
            <a href="" class="btn btn-dark btn-login-me rounded-pill px-5 py-3">Daftar Sekarang</a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\pages\membership.blade.php ENDPATH**/ ?>