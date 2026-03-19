<?php $__env->startSection('content'); ?>

    <div class="header-carousel owl-carousel">
        <?php $__empty_1 = true; $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="header-carousel-item bg-primary">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7 animated fadeInLeft">
                                <div class="text-sm-center text-md-start">
                                    <h4 class="text-white text-uppercase fw-bold mb-4"><?php echo e($carousel->pre_title); ?></h4>
                                    <h1 class="display-1 text-white mb-4"><?php echo e($carousel->title); ?></h1>
                                    <p class="mb-5 fs-5"><?php echo e($carousel->description); ?></p>
                                    <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                        <?php if($carousel->button1_text && $carousel->button1_url): ?>
                                            <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2"
                                                href="<?php echo e($carousel->button1_url); ?>"><i
                                                    class="fas fa-book-open me-2"></i><?php echo e($carousel->button1_text); ?></a>
                                        <?php endif; ?>
                                        <?php if($carousel->button2_text && $carousel->button2_url): ?>
                                            <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2"
                                                href="<?php echo e($carousel->button2_url); ?>"><?php echo e($carousel->button2_text); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 animated fadeInRight">
                                <div class="calrousel-img" style="object-fit: cover;">
                                    <img src="<?php echo e(asset('storage/' . $carousel->image_path)); ?>" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="header-carousel-item bg-primary">
                <div class="carousel-caption">
                    <p>Data carousel belum diatur.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="container-fluid feature bg-light py-5">
        
    </div>
    <div class="container-fluid bg-light about pb-5 pt-5">
        <div class="container pb-5">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item-content bg-white rounded p-5 h-100">
                        <h4 class="text-primary">Tentang Kami</h4>
                        <h1 class="display-4 mb-4">VISI & MISI</h1>
                        <?php echo $vision; ?>

                        <?php echo $mission; ?>

                        <a class="btn btn-primary rounded-pill py-3 px-5" href="<?php echo e(route('about')); ?>">More Information</a>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-5 h-100">
                        <div class="row g-4 justify-content-center">
                            <div class="col-12">

                                <div class="rounded bg-light">

                                    <?php

                                        $imageUrl = ($faq_image && Storage::disk('public')->exists($faq_image))
                                            ? asset('storage/' . $faq_image)
                                            : asset('assets/img/tim.png'); 
                                    ?>
                                    <img src="<?php echo e($imageUrl); ?>" class="img-fluid rounded w-100" alt="Tentang Kami">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up"><?php echo e($membershipCount); ?></span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Membership</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up"><?php echo e($bookCount); ?></span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Buku</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up"><?php echo e($journalCount); ?></span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Jurnal</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up"><?php echo e($teamCount); ?></span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Team Members</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- about end -->
    <div class="container-fluid blog py-5" id="blog">
        <div class="container py-5 text-center">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h1 class="display-4 mb-4">News And Updates</h1>
                <p class="mb-0">Dapatkan informasi terbaru seputar penerbitan buku dan jurnal, rilis terbaru, serta
                    aktivitas RITECS.</p>
            </div>
            <div class="row g-4 justify-content-start text-start">
                <?php $__empty_1 = true; $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-6 col-xxl-3 wow fadeInUp" data-wow-delay="0.6s">
                                <div class="blog-item rounded">
                                    <div class="blog-img rounded-top">
                                        <img src="<?php echo e(asset($journal->cover_path)); ?>" class="img-fluid rounded-top w-100" alt="<?php echo e($journal->title); ?>">
                                    </div>
                                    <div class="blog-content h-100 rounded p-3 d-grid align-content-between">
                                        <div class="card-body p-0 m-0">
                                            <a href="<?php echo e($journal->url_path); ?>" target="_blank" class="h6 d-inline-block mb-2"><?php echo e(Str::limit($journal->title, 55)); ?></a>
                                            <?php if($journal->keywords->isNotEmpty()): ?>
                                            <div class="kata-kunci my-1">
                                                <p class="h6 small mb-0 ">Kata Kunci : </p>
                                                <?php $__currentLoopData = $journal->keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="keywords-badge py-0 small my-1 ms-0 me-1"><?php echo e($keyword->name); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo e($journal->url_path); ?>" target="_blank" class="p-0 text-dark small position-relative bottom-0">Detail jurnal<i class="fa fa-arrow-right ms-2 small"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted fs-5">Jurnal tidak ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid faq-section bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="h-100">
                        <div class="mb-5">
                            <h4 class="text-primary">Some Important FAQ's</h4>
                            <h1 class="display-5 mb-0">Pertanyaan umum tentang layanan dan penerbitan di RITECS.</h1>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <?php $__empty_1 = true; $__currentLoopData = $home_faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo e($faq->id); ?>">
                                        <button class="accordion-button border-0 <?php echo e($loop->first ? '' : 'collapsed'); ?>"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($faq->id); ?>"
                                            aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                            Q: <?php echo e($faq->question); ?>

                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo e($faq->id); ?>"
                                        class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body rounded">A: <?php echo e($faq->answer); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p>Belum ada FAQ.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                    <img src="<?php echo e(asset('storage/' . $faq_image)); ?>" class="img-fluid w-100" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Team Start -->

    <div class="container-fluid team pb-5 pt-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">

                <h4 class="text-primary"><?php echo e($settings['team_pre_title'] ?? 'Our Team'); ?></h4>
                <h1 class="display-4 mb-4"><?php echo e($settings['team_title'] ?? 'Meet Our Expert Team Members'); ?></h1>
                <p class="mb-0">
                    <?php echo e($settings['team_description'] ?? 'Tim kami terdiri dari para profesional yang berdedikasi.'); ?>

                </p>
            </div>

            <div class="row g-4">

                <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="<?php echo e(asset('storage/' . $team->img_path)); ?>" alt="<?php echo e($team->name); ?>"
                                    class="img-fluid rounded-top w-100">
                                <div class="team-icon">
                                    <?php if($team->facebook_url): ?>
                                        <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="<?php echo e($team->facebook_url); ?>"
                                            target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <?php endif; ?>
                                    <?php if($team->twitter_url): ?>
                                        <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="<?php echo e($team->twitter_url); ?>"
                                            target="_blank"><i class="fab fa-twitter"></i></a>
                                    <?php endif; ?>
                                    <?php if($team->linkedin_url): ?>
                                        <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="<?php echo e($team->linkedin_url); ?>"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <?php endif; ?>
                                    <?php if($team->instagram_url): ?>
                                        <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href="<?php echo e($team->instagram_url); ?>"
                                            target="_blank"><i class="fab fa-instagram"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0"><?php echo e($team->name); ?></h4>
                                <p class="mb-0"><?php echo e($team->position); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center">
                        <p>Data tim belum tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- Team End -->

    <!-- Testimonial Start -->
    <!-- <div class="container-fluid testimonial pb-5 mt-5">
                    <div class="container pb-5">
                        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                            <h4 class="text-primary wow fadeInUp" data-wow-delay="0.2s">Testimonial</h4>
                            <h1 class="display-5 mb-4 wow fadeInUp" data-wow-delay="0.4s">What Our Customers Are Saying</h1>
                            <p class="mb-0 wow fadeInUp" data-wow-delay="0.6s">
                                Kami bangga telah membantu banyak penulis dan akademisi dalam menerbitkan karya mereka. Berikut adalah
                                beberapa testimoni dari klien kami yang puas dengan layanan RITECS.
                            </p>
                        </div>
                        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                            <div class="testimonial-item bg-light rounded">
                                <div class="row g-0">
                                    <div class="col-4  col-lg-4 col-xl-3">
                                        <div class="h-100">
                                            <img src="assets/img/testimonial-1.jpg" class="img-fluid h-100 rounded"
                                                style="object-fit: cover;" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8 col-lg-8 col-xl-9">
                                        <div class="d-flex flex-column my-auto text-start p-4">
                                            <h4 class="text-dark mb-0">Client Name</h4>
                                            <p class="mb-3">Profession</p>
                                            <div class="d-flex text-primary mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="mb-0">
                                                "Pelayanan RITECS sangat profesional dan responsif. Proses penerbitan buku saya berjalan
                                                lancar, mulai dari penyuntingan hingga terbit ber-ISBN. Sangat direkomendasikan untuk
                                                penulis pemula maupun profesional!"
                                            </p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item bg-light rounded">
                                <div class="row g-0">
                                    <div class="col-4  col-lg-4 col-xl-3">
                                        <div class="h-100">
                                            <img src="assets/img/testimonial-2.jpg" class="img-fluid h-100 rounded"
                                                style="object-fit: cover;" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8 col-lg-8 col-xl-9">
                                        <div class="d-flex flex-column my-auto text-start p-4">
                                            <h4 class="text-dark mb-0">Client Name</h4>
                                            <p class="mb-3">Profession</p>
                                            <div class="d-flex text-primary mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star text-body"></i>
                                            </div>
                                            <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim error
                                                molestiae aut modi corrupti fugit eaque rem nulla incidunt temporibus quisquam,
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item bg-light rounded">
                                <div class="row g-0">
                                    <div class="col-4  col-lg-4 col-xl-3">
                                        <div class="h-100">
                                            <img src="assets/img/testimonial-3.jpg" class="img-fluid h-100 rounded"
                                                style="object-fit: cover;" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8 col-lg-8 col-xl-9">
                                        <div class="d-flex flex-column my-auto text-start p-4">
                                            <h4 class="text-dark mb-0">Client Name</h4>
                                            <p class="mb-3">Profession</p>
                                            <div class="d-flex text-primary mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star text-body"></i>
                                                <i class="fas fa-star text-body"></i>
                                            </div>
                                            <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim error
                                                molestiae aut modi corrupti fugit eaque rem nulla incidunt temporibus quisquam,
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
    <!-- Testimonial End -->
    <!-- pop up start -->
    <!-- <div class="modal fade" id="ojsPopupModal" tabindex="-1" aria-labelledby="ojsPopupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ojsPopupModalLabel">Informasi Publikasi Jurnal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Temukan riset terbaru dan publikasi ilmiah berkualitas di Open Journal System (OJS) kami. Kami berkomitmen untuk menyebarkan pengetahuan dan inovasi di bidang Computer Science.
                            </p>
                            <p class="mb-0">
                                Kunjungi sekarang untuk mengakses artikel-artikel terbaru!
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            <a href="<?php echo e(route('journal')); ?>" class="btn btn-primary rounded-pill <?php echo e(in_array($title ?? '', ['Jurnal', 'Detail Jurnal']) ? 'active' : ''); ?>">Jurnal Kami</a>
                        </div>
                    </div>
                </div>
            </div> -->

    <!-- pop up end -->
     <?php if(session('status')): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "<?php echo e(session('status')); ?>",
            confirmButtonColor: '#3085d6'
        });
    });
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/pages/home.blade.php ENDPATH**/ ?>