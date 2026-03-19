<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between w-100 flex-wrap-reverse">
    <span class="text-dark d-flex">
        <div class="img-profile d-grid justify-content-start">
            <img id="avatarPreview"
                src="<?php echo e($user->img_path ? asset(str_replace('\\','/',$user->img_path)) : asset('assets/users/profile/profile_default.jpg')); ?>"
                class="bg-dark rounded object-fit-cover img-profile-profile" alt="">

            
            <div class="d-grid gap-2 mt-1">
                <button id="btnAvatarToggle" type="button" class="btn btn-link p-0 small normal-text text-start m-auto">
                    <i class="bi bi-pencil-square me-1 small"></i><span class="small">Ubah</span>
                </button>
                <button id="btnAvatarCancel" type="button" class="btn btn-link p-0 small text-danger d-none">
                    <i class="bi bi-x-circle me-1 small"></i><span class="small">Batal</span>
                </button>
            </div>

            
            <form id="avatarForm" class="d-none" action="<?php echo e(route('profile.avatar.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input id="avatarInput" type="file" name="avatar" accept="image/*" class="d-none">
                </form>
        </div>

        <div class="nama-profile ms-2">
            <h5 class="mb-0 fw-bold"><?php echo e($user->full_name); ?></h5>
            <?php if($membership): ?>
                <span class="normal-text text-member bg-primary small">Membership Aktif</span>
            <?php else: ?>
                <span class="normal-text text-member bg-warning small">Membership NonAktif</span>
            <?php endif; ?>
        </div>
    </span>

    <span class="d-flex flex-nowrap text-nowrap small mb-4">
        <a href="#" class="normal-text">Profile/</a>
        <a href="#" class="text-dark">Settings</a>
    </span>
</div>


<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e(session('success')); ?>

  <strong>Data diubah</strong> update berhasil.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session('warning')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo e(session('warning')); ?>

  <strong>Data tidak diubah</strong> update gagal.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


<div class="settings my-4 p-3 p-md-4 pt-4 pt-md-4 bg-light rounded">
    <h5 class="fw-bold mb-1 mt-0">Ubah Data Diri</h5>
    <p class="normal-text mb-4">Data lengkap diperlukan untuk proses pengunggahan Jurnal atau Buku</p>

    <div class="form-container p-0">
        <form action="<?php echo e(route('profile.settings.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="firstname" name="first_name"
                               value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
                        <label for="firstname">Nama Depan <sup class="text-danger">*</sup></label>
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="lastname" name="last_name"
                               value="<?php echo e(old('last_name', $user->last_name)); ?>">
                        <label for="lastname">Nama Belakang</label>
                        <?php $__errorArgs = ['last_name'];
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

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="NIK" name="nik"
                               value="<?php echo e(old('nik', $user->nik)); ?>">
                        <label for="NIK">NIK</label>
                        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="birthday" name="birthday"
                               value="<?php echo e(old('birthday', $user->birthday)); ?>">
                        <label for="birthday">Tanggal Lahir</label>
                        <?php $__errorArgs = ['birthday'];
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

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email"
                               value="<?php echo e(old('email', $user->email)); ?>" required>
                        <label for="email">Email <sup class="text-danger">*</sup></label>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password">
                        <label for="password">Password (kosongkan jika tidak diubah)</label>
                        <?php $__errorArgs = ['password'];
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

            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="address" name="address"
                               value="<?php echo e(old('address', $user->address)); ?>">
                        <label for="address">Alamat</label>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone"
                               value="<?php echo e(old('phone', $user->phone)); ?>">
                        <label for="phone">Nomor Telepon</label>
                        <?php $__errorArgs = ['phone'];
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

            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="city" name="city"
                               value="<?php echo e(old('city', $user->city)); ?>">
                        <label for="city">Kota</label>
                        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="province" name="province"
                               value="<?php echo e(old('province', $user->province)); ?>">
                        <label for="province">Provinsi</label>
                        <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php $__errorArgs = ['institution'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="institution" name="institution"
                               value="<?php echo e(old('institution', $user->institution)); ?>">
                        <label for="institution">Institution</label>
                        <?php $__errorArgs = ['institution'];
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

            <div class="mb-3 position-relative">
                <div class="border border-1 border-dashed rounded p-4 text-center bg-white position-relative" 
                    style="cursor:pointer;" 
                    onclick="document.getElementById('ktp').click()">
                    
                    <?php if($user->ktp_path): ?>
                        <img id="ktpPreview" src="<?php echo e(asset($user->ktp_path)); ?>" 
                            class="img-fluid rounded mb-2" style="max-height:200px;" alt="KTP Preview">
                    <?php else: ?>
                        <div id="ktpPlaceholder">
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
                        id="ktp" name="ktp_path" accept="image/*" 
                        onchange="previewKTP(this)">
                </div>
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
                <a href="<?php echo e(route('profile.ktp.delete')); ?>" 
                        class="btn btn-sm fw-normal btn-warning m-2 px-2 position-absolute end-0 bottom-0"
                        onclick="return confirm('Hapus KTP ini?')">
                        <i class="bi bi-trash me-1"></i> Hapus KTP
                        </a>
                <?php endif; ?>
            </div>

            <div class="footer-form mt-4">
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="d-flex w-100 justify-content-between gap-2">
                            <button type="submit" class="btn btn-dark rounded-pill w-100 px-4">Ubah Data Diri</button>
                            <a href="<?php echo e(route('profile.settings')); ?>" class="btn btn-outline-dark rounded-pill w-100 px-4">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnAvatarToggle');
    const btnCancel = document.getElementById('btnAvatarCancel');
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    const avatarPreview = document.getElementById('avatarPreview');
    const originalAvatar = avatarPreview.src; // simpan avatar lama

    let mode = 'ubah'; // 'ubah' | 'siap-simpan'

    btnToggle.addEventListener('click', function (e) {
        e.preventDefault();
        if (mode === 'ubah') {
            avatarInput.click();
        } else {
            avatarForm.submit();
        }
    });

    avatarInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            avatarPreview.src = url;

            btnToggle.innerHTML = '<i class="bi bi-check2 me-1 small"></i><span class="small">Simpan</span>';
            btnCancel.classList.remove('d-none');
            mode = 'siap-simpan';
        }
    });

    btnCancel.addEventListener('click', function (e) {
        e.preventDefault();
        // reset preview
        avatarPreview.src = originalAvatar;
        avatarInput.value = '';

        // reset tombol
        btnToggle.innerHTML = '<i class="bi bi-pencil-square me-1 small"></i><span class="small">Ubah</span>';
        btnCancel.classList.add('d-none');
        mode = 'ubah';
    });
});

</script>

<script>
function previewKTP(input) {
    const preview = document.getElementById('ktpPreview');
    const placeholder = document.getElementById('ktpPlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            if (preview) {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = "ktpPreview";
                img.src = e.target.result;
                img.classList.add("img-fluid","rounded","mb-2");
                img.style.maxHeight = "200px";
                placeholder.replaceWith(img);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\profile\settings.blade.php ENDPATH**/ ?>