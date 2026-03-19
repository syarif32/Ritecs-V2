<?php $__env->startSection('content'); ?>

    <div class="container-fluid feature bg-white py-5">

        <div class="container-fluid py-5 bg-light">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h1 class="display-4 mb-4">News And Updates</h1>
                <p class="mb-0">
                    RITECS menyediakan berbagai layanan penerbitan buku dan jurnal ilmiah, mulai dari penyuntingan naskah, penerjemahan, hingga penerbitan ber-ISBN. Kami berkomitmen untuk mendukung penulis dan akademisi dalam mewujudkan karya mereka.
                </p>
            </div>
        </div>
        
        <div class="container-fluid blog py-3">
            <div class="container py-5 text-center">
                <div class="text-start pb-2 ps-1 ps-md-3 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h5 class="text-primary">Terbaru</h5>
                    <h2 class="fw-bold mb-4">Paling Populer</h2>
                </div>
                <div class="container-fuild">
                    <div class="row g-4 justify-content-start text-start">
    
                        <?php $__empty_2 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-3 wow fadeInUp" data-wow-delay="0.4s">
                                <div class="blog-item ">
                                    <div class="blog-img rounded-top">
                                        <img src="<?php echo e(asset($book->cover_path)); ?>" class="img-fluid rounded-top w-100" alt="<?php echo e($book->title); ?>">
                                        <div class="blog-categiry py-1 px-4">
                                            <span><?php echo e($book->categories->first()->name ?? 'Buku'); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-content p-3">
                                        
                                        
                                        <div class="blog-comment d-flex justify-content-between mb-2">
                                            
                                            <div class="small pe-2 text-dark">
                                                <i class="bi bi-person-lines-fill text-primary me-1"></i>
                                                <?php echo e($book->writers->pluck('name')->join(', ')); ?>

                                            </div>
                                            
                                            
                                            <div class="small text-nowrap flex-shrink-0 text-dark">
                                                <i class="bi bi-calendar-range text-primary"></i>
                                                <?php echo e(\Carbon\Carbon::parse($book->publish_date)->format('j M Y')); ?>

                                            </div>
                                        </div>

                                        
                                        <div class="d-flex align-items-center mb-3 small">
                                            <span class="me-3 text-dark">
                                                <i class="bi bi-eye-fill text-primary me-1"></i> <?php echo e(number_format($book->visitor_count ?? 0)); ?>

                                            </span>
                                            <span class="text-dark">
                                                <i class="bi bi-cloud-arrow-down-fill text-success me-1"></i> <?php echo e(number_format($book->download_count ?? 0)); ?>

                                            </span>
                                        </div>

                                        
                                        <a href="<?php echo e(route('buku.detail', $book->book_id)); ?>" class="h6 d-inline-block mb-2"><?php echo e($book->title); ?></a>
                                        
                                        
                                        <div class="mb-2">
                                            <span class="d-flex align-items-start gap-2 flex-wrap">
                                                <?php if($book->ebook_price): ?>
                                                <span class="text-dark my-1 my-md-0 small text-harga text-nowrap">Rp <?php echo e(number_format($book->ebook_price, 0, ',', '.')); ?> (pdf)</span>
                                                <?php endif; ?>
                                                <?php if($book->print_price): ?>
                                                <span class="text-dark fw-bold my-1 my-md-0 small text-harga text-nowrap">Rp <?php echo e(number_format($book->print_price, 0, ',', '.')); ?> (cetak)</span> 
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        
                                        
                                        <a href="<?php echo e(route('buku.detail', $book->book_id)); ?>" class="p-0 small">Lihat Buku <i class="fa fa-arrow-right small"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <div class="col-12 text-center">
                                <p>Belum ada buku yang tersedia.</p>
                            </div>
                        <?php endif; ?>
    
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\pages\buku.blade.php ENDPATH**/ ?>