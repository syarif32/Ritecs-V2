<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-12">
                <div class="mb-5">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="footer-item">
                                <a href="<?php echo e(route('home')); ?>" class="navbar-brand position-relative p-0">
                                    <h3 class="text-white"><img width="120"
                                            src="<?php echo e(asset('assets/img/logo/logo-text-white.webp')); ?>" alt="Logo"> </h3>
                                </a>
                                <p class="text-white mb-4">Perkumpulan Riset dan Inovasi pada Teknologi Computer
                                    Science(Ritecs)</p>
                                <div class="footer-btn d-flex">
    <a class="btn btn-md-square rounded-circle me-3" href="<?php echo e($global_settings['social_facebook'] ?? '#'); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a class="btn btn-md-square rounded-circle me-3" href="<?php echo e($global_settings['social_twitter'] ?? '#'); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
    <a class="btn btn-md-square rounded-circle me-3" href="<?php echo e($global_settings['social_instagram'] ?? '#'); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
    <a class="btn btn-md-square rounded-circle me-0" href="<?php echo e($global_settings['social_linkedin'] ?? '#'); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="footer-item">
                                <h4 class="text-white mb-4">Useful Links</h4>
                                <a href="<?php echo e(route('about')); ?>#visi-misi"><i class="fas fa-angle-right me-2"></i> About Us</a>
                                <a href="<?php echo e(route('service')); ?>"><i class="fas fa-angle-right me-2"></i> Services</a>
                                <a href="<?php echo e(route('petunjuk-penulis')); ?>"><i class="fas fa-angle-right me-2"></i>Penerbitan Buku</a>
                                <a href="<?php echo e(route('journal')); ?>"><i class="fas fa-angle-right me-2"></i> Penerbitan Jurnal</a>
                                 <a href="<?php echo e(route('membership.index')); ?>"><i class="fas fa-angle-right me-2"></i> Direktori Anggota</a>
                                <a href="<?php echo e(route('contact.create')); ?>"><i class="fas fa-angle-right me-2"></i> Contact</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="footer-item">
                               
                               <h4 class="mb-4 text-white"><?php echo e($global_settings['footer_instagram_title'] ?? 'Instagram'); ?></h4>
                                <div class="row g-3">
                                   
                                   <?php $__empty_1 = true; $__currentLoopData = $footer_galleries ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-4">
        <div class="footer-instagram rounded">
            <img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" 
                 class="img-fluid w-100" 
                 alt="Instagram Gallery Image">
            <div class="footer-search-icon">
                <a href="<?php echo e($gallery->link_url ?? asset('sites/storage/' . $gallery->image_path)); ?>" 
                   data-lightbox="footerInstagram-<?php echo e($gallery->id); ?>" 
                   class="my-auto" 
                   target="_blank">
                    <i class="fas fa-link text-white"></i>
                </a>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12"><p class="text-white-50">Belum ada gambar.</p></div>
<?php endif; ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="row g-4">
                                
<div class="col-lg-6 col-xl-4">
    <div class="d-flex">
        <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">
            <i class="fas fa-map-marker-alt fa-2x"></i>
        </div>
        <div>
            <h4 class="text-white">Address</h4>
            
            <p class="mb-0"><?php echo nl2br(e($global_settings['contact_address'] ?? 'Alamat belum diatur.')); ?></p>
        </div>
    </div>
</div>


<div class="col-lg-6 col-xl-4">
    <div class="d-flex">
        <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">
            <i class="fas fa-envelope fa-2x"></i>
        </div>
        <div>
            <h4 class="text-white">Mail Us</h4>
            
            <p class="mb-0"><?php echo e($global_settings['contact_email'] ?? 'Email belum diatur.'); ?></p>
        </div>
    </div>
</div>


<div class="col-lg-6 col-xl-4">
    <div class="d-flex">
        <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">
            <i class="fa fa-phone-alt fa-2x"></i>
        </div>
        <div>
            <h4 class="text-white">Telephone</h4>
            
            <p class="mb-0"><?php echo e($global_settings['contact_phone'] ?? 'Telepon belum diatur.'); ?></p>
        </div>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-end mb-md-0">
                <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>RITECS</a>, All right reserved.</span>
            </div>
            <div class="col-md-6 text-center text-md-start text-body">
                Distributed By <a class="border-bottom text-white" href="">RITECS</a>
            </div>
        </div>
    </div>
</div>
<div id="journal-floating-container" class="journal-fab-container">
            <a href="https://ritecs.org/journal/" target="_blank" id="journal-floating-button" class="journal-fab bg-warning">
                <div class="journal-fab-content">
                    <span class="journal-fab-title">RITECS</span>
                    <span class="journal-fab-subtitle fw-bold">OPEN JOURNAL SYSTEM</span>
                </div>
            </a>
            <!--<button id="close-journal-fab" class="journal-fab-close">&times;</button>-->
        </div>
<a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/partials/footer.blade.php ENDPATH**/ ?>