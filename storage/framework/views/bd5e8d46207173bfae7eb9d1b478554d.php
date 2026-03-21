    

    <?php $__env->startSection('content'); ?>

        <div class="d-flex justify-content-between w-100 my-2">
            <span class="text-dark mb-4 d-flex">
                <img src="<?php echo e(asset($user->img_path ?? 'assets/users/profile/profile_default.jpg')); ?>" 
                    class="bg-dark rounded object-fit-cover img-profile-profile me-3" 
                    alt="Foto <?php echo e($user->first_name); ?>">
                <div class="nama-profile">
                    <h5 class="mb-0 fw-bold">
                        <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

                    </h5>
                    <?php if($membership): ?>
                        <span class="normal-text text-member bg-primary small">Membership Aktif</span>
                    <?php else: ?>
                        <span class="normal-text text-member bg-warning small">Membership NonAktif</span>
                    <?php endif; ?>
                </div>
            </span>
            <span class="d-none d-md-flex flex-nowrap text-nowrap small">
                <a href="#" class="normal-text">Profile/</a>
                <a href="#" class="text-dark">Membership</a>
            </span>
        </div>



        <div class="container-fluid">
        <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>

       <?php if($membership && $membership->status == 1): ?>
            <div class="shadow-none membership-card mb-4 border-0 position-relative">
                <div class="row g-0 align-items-center py-2">
                    <div class="col-xl-4 text-start position-relative membership-image-wrapper">
                        
                        
                        <img id="membershipCard" 
                             src="<?php echo e(route('profile.membership.card.view', $membership->membership_id)); ?>?v=<?php echo e(time()); ?>" 
                             alt="Membership Card" 
                             class="img-fluid" 
                             style="max-height:400px;">

                        <div class="membership-image-overlay d-flex flex-column justify-content-center align-items-center text-center">
                            
                            <a href="<?php echo e(route('profile.membership.card.view', $membership->membership_id)); ?>" 
                            target="_blank" 
                            class="btn btn-light btn-sm rounded-pill fw-normal mb-2 px-3">
                                <i class="bi bi-eye me-1"></i> Lihat Kartu
                            </a>

                            <a href="<?php echo e(route('profile.membership.card.download', $membership->membership_id)); ?>" 
                               class="btn btn-primary btn-sm rounded-pill fw-normal px-3 mt-2">
                                <i class="bi bi-download me-1"></i> Unduh Kartu PDF
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-8 p-0 p-xl-4 pt-xl-0 pt-4 text-center text-md-start">
                        <h4 class="fw-bold text-dark mb-1">Premium Membership</h4>
                        <p class="mb-2 text-muted">
                            Berlaku hingga: <strong><?php echo e(\Carbon\Carbon::parse($membership->end_date)->translatedFormat('d F Y')); ?></strong>
                        </p>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#perpanjangMembershipModal" class="btn btn-sm btn-dark btn-login-me rounded-pill fw-normal px-3">
                            <i class="bi bi-clock-history me-1"></i> Perpanjang Membership
                        </button>
                        
                        <?php if($pending->where('type','extendedPayments')->where('status','pending')->count() > 0): ?>
                            <p class="mt-2 text-danger small">
                                Anda sudah mengajukan perpanjangan membership. Menunggu verifikasi admin.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php elseif($membership && $membership->status == 0): ?>
        
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <h5 class="fw-bold mb-1">Membership Anda Ditangguhkan</h5>
            <p class="mb-1">Status membership anda ditangguhkan oleh pengelola.</p>
            <p class="mb-0">
                Silakan hubungi admin melalui 
                <a href="https://wa.me/6285225969825" target="_blank" class="fw-bold text-success">
                    WhatsApp (0852-2596-9825)
                </a>.
            </p>
        </div>
        
        <?php elseif($pending->count() > 0): ?>
        
        <div class="mt-4">
            <h5 class="fw-bold mb-3">Transaksi Dalam Proses Verifikasi</h5>
            <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold text-dark">Transaksi #<?php echo e($tx->transaction_id); ?></h6>
                        <p class="mb-1 small text-muted">Nama User: <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></p>
                        <p class="mb-1 small text-muted">Nama Pengirim: <?php echo e($tx->sender_name); ?></p>
                        <p class="mb-1 small text-muted">Rekening Pengirim: <?php echo e($tx->sender_bank); ?></p>
                        <p class="mb-1 small text-muted">Nominal: Rp <?php echo e(number_format($tx->amount,0,',','.')); ?></p>
                        <p class="mb-1"><span class="badge bg-warning text-dark">Status: Dalam Verifikasi</span></p>
                        
                        <?php if($tx->proof_path): ?>
                            <div class="my-2">
                                <img src="<?php echo e(asset($tx->proof_path)); ?>" 
                                    alt="Bukti Transfer" 
                                    class="img-fluid rounded" 
                                    style="max-height:200px;">
                            </div>
                        <?php endif; ?>

                        <?php
                            $waNumber = "6285225969825"; // nomor admin
                            $waMessage = urlencode(
                                "Halo Admin, saya ingin konfirmasi transaksi:\n".
                                "ID Transaksi: #{$tx->transaction_id}\n".
                                "Nama User: {$user->first_name} {$user->last_name}\n".
                                "Nama Pengirim: {$tx->sender_name}\n".
                                "Bank Pengirim: {$tx->sender_bank}\n".
                                "Bukti Transfer: ".asset($tx->proof_path)
                            );
                            $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
                        ?>

                        <a href="<?php echo e($waUrl); ?>" target="_blank" class="btn btn-success btn-sm rounded-pill">
                            <i class="bi bi-whatsapp me-1"></i> Konfirmasi via WhatsApp
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
            <div class="container p-0 m-0">

                <div class="row">
                    <div class="col-12 col-xl-5 ps-xl-0">
                        <div class="pricing-card popular">
                            <div class="card-header text-center"><h4 class="card-title">Membership</h4></div>
                            <div class="card-body text-center">
                                <div class="price-tag">
                                    <sup>Rp</sup><span class="display-4">150K</span><span class="text-muted">/Tahun</span>
                                </div>
                                <p class="mt-2">Pilihan terbaik untuk akses penuh dan benefit maksimal</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-check-circle me-2"></i>Diskon hingga 15% semua layanan</li>
                                <li class="list-group-item"><i class="fas fa-check-circle me-2"></i>Penghargaan Bagi Reviewer</li>
                            </ul>
                            <div class="card-footer text-center">
                                <?php
                                    $requiredFields = [
                                        'first_name' => 'Nama Depan',
                                        'last_name'  => 'Nama Belakang',
                                        'email'      => 'Email',
                                        'nik'        => 'NIK',
                                        'birthday'   => 'Tanggal Lahir',
                                        'phone'      => 'No. Telepon',
                                        'address'    => 'Alamat',
                                        'city'       => 'Kota',
                                        'province'   => 'Provinsi',
                                        'ktp_path'   => 'Foto KTP',
                                    ];

                                    $incomplete = [];
                                    foreach ($requiredFields as $field => $label) {
                                        if (empty($user->$field)) {
                                            $incomplete[] = $label;
                                        }
                                    }
                                ?>

                                <?php if(count($incomplete) > 0): ?>
                                    
                                    <div class="alert alert-warning small text-start">
                                        <strong>⚠️ Data diri belum lengkap.</strong><br>
                                        Untuk berlangganan sebagai <strong>Membership</strong> silakan lengkapi dulu data berikut:
                                        <ul class="mb-2">
                                            <?php $__currentLoopData = $incomplete; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($item); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <button data-bs-toggle="modal" data-bs-target="#checkoutModal" class="btn btn-sm btn-primary rounded-pill w-100 fw-bold">
                                            Lengkapi Data & Daftar
                                        </button>
                                    </div>
                                <?php else: ?>
                                    
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#checkoutModal" 
                                        class="btn btn-primary rounded-pill w-100">
                                        Pilih Paket
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 mt-5 mt-xl-0">
                        <div class="row">
                            <div class="col-12 py-0">
                                <div class="card action-card border-0 shadow-none">
                                    <div class="card-body p-3">
                                        <h6 class="fw-semibold text-dark">
                                            <i class="bi bi-book-fill me-1"></i>Publikasi Buku
                                        </h6>
                                        <p class="text-muted small mb-1">
                                            Publikasikan buku ke platform kami secara profesional.
                                            Dapatkan ISBN resmi, desain cover, layout isi, dan distribusi digital.
                                        </p>
                                        <a href="#" class="btn btn-sm btn-outline-dark rounded-pill fw-normal px-3">
                                            <i class="bi bi-whatsapp me-1"></i> Hubungi tim kami
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-0">
                                <div class="card action-card border-0 shadow-none">
                                    <div class="card-body p-3">
                                        <h6 class="fw-semibold text-primary">
                                            <i class="fas fa-file-alt me-1"></i> Publikasi Jurnal
                                        </h6>
                                        <p class="text-muted small mb-1">
                                            Submit & publikasikan jurnal ke portal akademik nasional/internasional.
                                            Tim kami akan membantu proses peer-review dan penerbitan.
                                        </p>
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill fw-normal px-3">
                                            <i class="bi bi-whatsapp me-1"></i> Hubungi tim kami
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-0">
                                <div class="card action-card border-0 shadow-none">
                                    <div class="card-body p-3">
                                        <h6 class="fw-semibold text-muted">
                                            <i class="bi bi-patch-check-fill me-1"></i> Training Center & HAKI
                                        </h6>
                                        <p class="text-muted small mb-1">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus nihil, 
                                            totam iste voluptatem magni at repudiandae.
                                        </p>
                                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill fw-normal px-3">
                                            <i class="bi bi-whatsapp me-1"></i> Hubungi tim kami
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($pending->count() > 0): ?>
                <div class="mt-4">
                    <h5 class="fw-bold mb-3">Transaksi Dalam Proses Verifikasi</h5>
                    <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark">Transaksi #<?php echo e($tx->id); ?></h6>
                                <p class="mb-1 small text-muted">Nama User: <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></p>
                                <p class="mb-1 small text-muted">Nama Pengirim: <?php echo e($tx->sender_name); ?></p>
                                <p class="mb-1 small text-muted">Rekening Pengirim: <?php echo e($tx->sender_bank); ?></p>
                                <p class="mb-1 small text-muted">Nominal: Rp <?php echo e(number_format($tx->amount,0,',','.')); ?></p>
                                <p class="mb-1"><span class="badge bg-warning text-dark">Status: Dalam Verifikasi</span></p>
                                
                                <?php if($tx->proof_path): ?>
                                    <div class="my-2">
                                        <img src="<?php echo e(asset($tx->proof_path)); ?>" 
                                            alt="Bukti Transfer" 
                                            class="img-fluid rounded" 
                                            style="max-height:200px;">
                                    </div>
                                <?php endif; ?>

                                <?php
                                    $waNumber = "6285225969825"; // nomor admin
                                    $waMessage = urlencode(
                                        "Halo Admin, saya ingin konfirmasi transaksi:\n".
                                        "ID Transaksi: #{$tx->id}\n".
                                        "Nama User: {$user->first_name} {$user->last_name}\n".
                                        "Nama Pengirim: {$tx->sender_name}\n".
                                        "Bank Pengirim: {$tx->sender_bank}\n".
                                        "Bukti Transfer: ".asset($tx->proof_path)
                                    );
                                    $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
                                ?>

                                <a href="<?php echo e($waUrl); ?>" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp me-1"></i> Konfirmasi via WhatsApp
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>


        <?php endif; ?>
        </div>

        <div class="mb-4 mt-5">
            <h4 class="fw-semibold border-bottom border-primary pb-2 text-center text-md-start">Keuntungan Membership</h4>
            <div class="row g-4 mt-1">
                <div class="col-xl-4">
                    <div class="card benefit-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="benefit-icon shadow-sm mb-3">
                                <i class="bi bi-gift fs-3"></i>
                            </div>
                            <h5 class="fw-bold">Diskon Eksklusif</h5>
                            <p class="text-muted mb-0">Potongan harga khusus untuk produk dan layanan terpilih.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card benefit-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="benefit-icon shadow-sm mb-3">
                                <i class="bi bi-stars fs-3"></i>
                            </div>
                            <h5 class="fw-bold">Akses Premium</h5>
                            <p class="text-muted mb-0">Buka konten dan fitur eksklusif hanya untuk member.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card benefit-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="benefit-icon shadow-sm mb-3">
                                <i class="bi bi-headset fs-3"></i>
                            </div>
                            <h5 class="fw-bold">Prioritas Layanan</h5>
                            <p class="text-muted mb-0">Respons dan dukungan lebih cepat dari tim kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade " id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered border-4 border-dark">
                <div class="modal-content border-bottom-0 border-start-0 border-end-0 border-5 border-primary rounded-3 shadow bg-light p-3">
                    <div class="col-lg-8 pb-0 pt-4 text-center m-auto">
                        <h5 class="modal-title h4 display-6 fw-bold" id="checkoutModalLabel">Upgrade Membership</h5>
                        <p>Upgrade ke membership untuk menikmati berbagai fitur dan potongan biaya publikasi hingga 15% pada seluruh layanan</p>
                    </div>            
                    <form method="POST" action="<?php echo e(route('profile.member.submit')); ?>" enctype="multipart/form-data" class="membership-transaction-form">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body p-2">

                            <div class="settings my-4 p-3 p-md-4 pt-4 bg-light rounded">
                                <h5 class="fw-bold mb-1">Lengkapi Data Diri</h5>
                                <p class="normal-text mb-3">Data ini wajib diisi untuk keperluan membership.</p>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
                                            <label>Nama Depan <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>">
                                            <label>Nama Belakang</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="nik" value="<?php echo e(old('nik', $user->nik)); ?>">
                                            <label>NIK</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="date" class="form-control" name="birthday" value="<?php echo e(old('birthday', $user->birthday)); ?>">
                                            <label>Tanggal Lahir</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" value="<?php echo e(old('email', $user->email)); ?>" readonly>
                                            <label>Email <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                            <label>Nomor Telepon</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-3">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="city" value="<?php echo e(old('city', $user->city)); ?>">
                                            <label>Kota</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="province" value="<?php echo e(old('province', $user->province)); ?>">
                                            <label>Provinsi</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="institution" value="<?php echo e(old('institution', $user->institution)); ?>">
                                            <label>Institusi</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="address" value="<?php echo e(old('address', $user->address)); ?>">
                                            <label>Address</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload KTP -->
                                <div class="mb-3 position-relative">
                                    <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative" 
                                        style="cursor:pointer;" 
                                        onclick="document.getElementById('ktpCheckout').click()">

                                        <?php if($user->ktp_path): ?>
                                            <img id="ktpPreviewCheckout" src="<?php echo e(asset($user->ktp_path)); ?>" 
                                                class="img-fluid rounded mb-2" style="max-height:200px;" alt="KTP Preview">
                                        <?php else: ?>
                                            <div id="ktpPlaceholderCheckout">
                                                <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                                                <p class="text-muted mb-0">Klik untuk mengunggah KTP</p>
                                            </div>
                                        <?php endif; ?>

                                        <input type="file" 
                                            class="form-control d-none <?php $__errorArgs = ['ktp_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="ktpCheckout" name="ktp_path" accept="image/*" 
                                            onchange="previewKTP(this, 'ktpPreviewCheckout', 'ktpPlaceholderCheckout')">
                                    </div>

                                    <div class="invalid-feedback ktp-error" >KTP wajib diunggah.</div>

                                    <?php $__errorArgs = ['ktp_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                      <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                    <?php if($user->ktp_path): ?>
                                    <a href="<?php echo e(route('profile.ktp.delete', ['modal' => 'checkoutModal'])); ?>" 
                                        class="btn btn-sm fw-normal btn-warning m-2 px-2 position-absolute end-0 bottom-0"
                                        onclick="return confirm('Hapus KTP ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus KTP
                                    </a>

                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- Nama Pengirim -->
                                <input type="hidden" name="type" value="firstPayments"> 


                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input required type="text" class="form-control <?php $__errorArgs = ['sender_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sender_name" name="sender_name" placeholder="Nama Pengirim" value="<?php echo e(old('sender_name')); ?>">
                                        <label for="sender_name">Nama Rekening Anda</label>
                                        <?php $__errorArgs = ['sender_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Bank Pengirim -->
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input required type="text" class="form-control <?php $__errorArgs = ['sender_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sender_bank" name="sender_bank" placeholder="Bank Pengirim" value="<?php echo e(old('sender_bank')); ?>">
                                        <label for="sender_bank">Nomor Rekening Anda</label>
                                        <?php $__errorArgs = ['sender_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <!-- Bank Tujuan -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="bank_id" name="bank_id" required>
                                                <option value="">-- Pilih Bank Tujuan --</option>
                                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($b->bank_id); ?>" <?php echo e(old('bank_id') == $b->bank_id ? 'selected' : ''); ?>>
                                                    <?php echo e($b->bank_name); ?> - <?php echo e($b->account_number); ?> (<?php echo e($b->account_name); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <label for="bank_id">Bank Tujuan</label>
                                                <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Nominal -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="amount" name="amount" aria-readonly="true" required>
                                                    <option value="150000">Rp. 150.000/Tahun</option>
                                                </select>
                                                <label for="amount">Paket Membership</label>
                                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bukti Transfer -->
                                <div class="col-md-12">
                                    <div class="mb-3 position-relative">
                                        <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative" 
                                            style="cursor:pointer;" 
                                            onclick="document.getElementById('proof').click()">
                                            
                                        <input type="file"
                                           class="form-control text-center d-none <?php $__errorArgs = ['proof'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="proof" name="proof" accept="image/*" 
                                           onchange="previewProof(this, 'proofPreview', 'proofPlaceholder')">
                                        
                                        <div id="proofPlaceholder">
                                            <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                                            <p class="text-muted mb-0">Klik untuk mengunggah Bukti Transfer</p>
                                        </div>
                                        <img id="proofPreview" class="img-fluid rounded mb-2 text-center m-auto" style="max-height:200px; display:none;" alt="Proof Preview">

                                        </div>
                                        <?php $__errorArgs = ['proof'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div> 
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer text-center d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-dark rounded-pill px-4">Kirim Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade " id="perpanjangMembershipModal" tabindex="-1" aria-labelledby="perpanjangMembershipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered border-4 border-dark">
                <div class="modal-content border-bottom-0 border-start-0 border-end-0 border-5 border-primary rounded-3 shadow bg-light p-3">
                    <div class="col-lg-8 pb-0 pt-4 text-center m-auto">
                        <h5 class="modal-title h4 display-6 fw-bold" id="perpanjangMembershipModalLabel">Perpanjang Membership</h5>
                        
                    </div>       
                    <form method="POST" action="<?php echo e(route('profile.member.submit')); ?>" enctype="multipart/form-data" class="membership-transaction-form">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body p-2">

                            <div class="settings my-4 p-3 p-md-4 pt-4 bg-light rounded">
                                <h5 class="fw-bold mb-1">Lengkapi Data Diri</h5>
                                <p class="normal-text mb-3">Data ini wajib diisi untuk keperluan membership.</p>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
                                            <label>Nama Depan <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>">
                                            <label>Nama Belakang</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="nik" value="<?php echo e(old('nik', $user->nik)); ?>">
                                            <label>NIK</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="date" class="form-control" name="birthday" value="<?php echo e(old('birthday', $user->birthday)); ?>">
                                            <label>Tanggal Lahir</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="email" class="form-control" name="email" value="<?php echo e(old('email', $user->email)); ?>" readonly>
                                            <label>Email <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                            <label>Nomor Telepon</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-cols-1 row-cols-lg-3">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="city" value="<?php echo e(old('city', $user->city)); ?>">
                                            <label>Kota</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="province" value="<?php echo e(old('province', $user->province)); ?>">
                                            <label>Provinsi</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="institution" value="<?php echo e(old('institution', $user->institution)); ?>">
                                            <label>Institusi</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="address" value="<?php echo e(old('address', $user->address)); ?>">
                                            <label>Address</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload KTP -->
                                <div class="mb-3 position-relative">
                                    <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative" 
                                        style="cursor:pointer;" 
                                        onclick="document.getElementById('ktpExtend').click()">

                                        <?php if($user->ktp_path): ?>
                                            <img id="ktpPreviewExtend" src="<?php echo e(asset($user->ktp_path)); ?>" 
                                                class="img-fluid rounded mb-2" style="max-height:200px;" alt="KTP Preview">
                                        <?php else: ?>
                                            <div id="ktpPlaceholderExtend">
                                                <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                                                <p class="text-muted mb-0">Klik untuk mengunggah KTP</p>
                                            </div>
                                        <?php endif; ?>

                                        <input type="file" 
                                            class="form-control d-none <?php $__errorArgs = ['ktp_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="ktpExtend" name="ktp_path" accept="image/*" 
                                            onchange="previewKTP(this, 'ktpPreviewExtend', 'ktpPlaceholderExtend')"
                                        >
                                    </div>

                                    <div class="invalid-feedback ktp-error" >KTP wajib diunggah.</div>
                                
                                    <?php $__errorArgs = ['ktp_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                      <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                    <?php if($user->ktp_path): ?>
                                    <a href="<?php echo e(route('profile.ktp.delete', ['modal' => 'perpanjangMembershipModal'])); ?>" 
                                        class="btn btn-sm fw-normal btn-warning m-2 px-2 position-absolute end-0 bottom-0"
                                        onclick="return confirm('Hapus KTP ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus KTP
                                    </a>

                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- Nama Pengirim -->
                                <input type="hidden" name="type" value="extendedPayments"> 


                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input required type="text" class="form-control <?php $__errorArgs = ['sender_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sender_name" name="sender_name" placeholder="Nama Pengirim" value="<?php echo e(old('sender_name')); ?>">
                                        <label for="sender_name">Nama Rekening Anda</label>
                                        <?php $__errorArgs = ['sender_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Bank Pengirim -->
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input required type="text" class="form-control <?php $__errorArgs = ['sender_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sender_bank" name="sender_bank" placeholder="Bank Pengirim" value="<?php echo e(old('sender_bank')); ?>">
                                        <label for="sender_bank">Nomor Rekening Anda</label>
                                        <?php $__errorArgs = ['sender_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <!-- Bank Tujuan -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating">
                                                <select required class="form-select <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="bank_id" name="bank_id">
                                                <option value="">-- Pilih Bank Tujuan --</option>
                                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($b->bank_id); ?>" <?php echo e(old('bank_id') == $b->bank_id ? 'selected' : ''); ?>>
                                                    <?php echo e($b->bank_name); ?> - <?php echo e($b->account_number); ?> (<?php echo e($b->account_name); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <label for="bank_id">Bank Tujuan</label>
                                                <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Nominal -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating">
                                                <select required class="form-select <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="amount" name="amount" aria-readonly="true">
                                                    <option value="150000">Rp. 150.000/Tahun</option>
                                                </select>
                                                <label for="amount">Paket Membership</label>
                                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bukti Transfer -->
                                <div class="col-md-12">
                                    <div class="mb-3 position-relative">
                                        <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative"
                                            style="cursor:pointer;"
                                            onclick="document.getElementById('proofExtend').click()">

                                            <input required type="file" 
                                               class="form-control d-none text-center"
                                               id="proofExtend" name="proof" accept="image/*"
                                               onchange="previewProof(this, 'proofPreviewExtend', 'proofPlaceholderExtend')">
                                            
                                            <div id="proofPlaceholderExtend">
                                                <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                                                <p class="text-muted mb-0">Klik untuk mengunggah Bukti Transfer</p>
                                            </div>
                                            <img id="proofPreviewExtend" class="img-fluid rounded mb-2 text-center m-auto" style="max-height:200px; display:none;" alt="Proof Preview">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer text-center d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-dark rounded-pill px-4">Kirim Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
        async function downloadCard() {
            try {
                const img = document.getElementById('membershipCard');
                const res = await fetch(img.src);
                const svgText = await res.text();

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                const svgElement = new DOMParser().parseFromString(svgText, 'image/svg+xml').documentElement;
                canvas.width = svgElement.viewBox.baseVal.width || 885;
                canvas.height = svgElement.viewBox.baseVal.height || 552;

                // Canvg versi 3 (UMD)
                const v = await canvg.Canvg.fromString(ctx, svgText);
                await v.render();

                const pngUrl = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = pngUrl;
                a.download = 'kartu-membership-<?php echo e($membership->member_number ?? "guest"); ?>.png';
                a.click();
            } catch(e) {
                console.error(e);
                alert("Gagal download: " + e.message);
            }
        }
        </script>

        <script>
            function previewProof(input, previewId, placeholderId) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
            
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.style.display = "block"; // tampilkan
                        }
                        if (placeholder) {
                            placeholder.style.display = "none"; // sembunyikan
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

    <script>
    function previewKTP(input, previewId, placeholderId) {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview) {
                    // Jika sudah ada img preview → update src
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    preview.style.maxHeight = "200px"; // ✅ set tinggi konsisten
                    preview.classList.add("img-fluid","rounded","mb-2");
                } else {
                    // Kalau belum ada, buat elemen img baru
                    const img = document.createElement('img');
                    img.id = previewId;
                    img.src = e.target.result;
                    img.classList.add("img-fluid","rounded","mb-2");
                    img.style.maxHeight = "200px";
                    if (placeholder) placeholder.replaceWith(img);
                }

                if (placeholder) {
                    placeholder.style.display = "none"; // sembunyikan placeholder
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>


    <?php if(session('openModal')): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalId = "<?php echo e(session('openModal')); ?>";
            var myModal = new bootstrap.Modal(document.getElementById(modalId));
            myModal.show();
        });
    </script>
    <?php endif; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // cek apakah user sudah punya KTP di server
        const userHasKTP = Boolean(<?php echo json_encode(!empty($user->ktp_path), 15, 512) ?>);
    
        console.log("DEBUG userHasKTP =", userHasKTP); // 👀 cek di console
    
        // cari semua form membership
        document.querySelectorAll(".membership-transaction-form").forEach(function(form, index) {
            const fileInput = form.querySelector('input[name="ktp_path"]');
            console.log("DEBUG Form", index, "fileInput found?", !!fileInput);
    
            form.addEventListener("submit", function(e) {
                console.log("DEBUG submit form index", index);
    
                if (!userHasKTP && (!fileInput || fileInput.files.length === 0)) {
                    e.preventDefault();
                    console.log("DEBUG kondisi terpenuhi: blokir submit karena KTP kosong");
                    alert("⚠️ KTP wajib diunggah sebelum melanjutkan!");
                    if (fileInput) fileInput.focus();
                    return false;
                }
            });
        });
    });
    </script>






    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/profile/member.blade.php ENDPATH**/ ?>