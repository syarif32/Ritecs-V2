 

<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title">Manajemen Pengguna</h2>
                    <p class="text-muted">Kelola akses role pengguna dan administrator sistem.</p>
                </div>
            </div>

            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="fe fe-check-circle fe-16 mr-2"></span> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="fe fe-alert-triangle fe-16 mr-2"></span> <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Pengguna</th>
                                <th>Role Saat Ini</th>
                                <th>Status Akun</th>
                                <th>Terdaftar</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                       <tbody>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm mr-3">
                     <img src="<?php echo e($user->img_path ? asset($user->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div>
                    <p class="mb-0 text-muted"><strong><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></strong></p>
                    <small class="mb-0 text-muted"><?php echo e($user->email); ?></small>
                </div>
            </div>
        </td>
        <td>
            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="badge badge-pill <?php echo e($role->name == 'Admin' ? 'badge-primary' : 'badge-secondary'); ?>"><?php echo e($role->name); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </td>
        <td class="text-right">
            <?php if($user->hasRole('Admin')): ?>
                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#demoteModal-<?php echo e($user->user_id); ?>">
                    <i class="fe fe-shield-off fe-12 mr-1"></i> Demote
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#promoteModal-<?php echo e($user->user_id); ?>">
                    <i class="fe fe-shield fe-12 mr-1"></i> Promote
                </button>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3 d-flex justify-content-center">
                <?php echo e($users->links()); ?>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\usersmanagement\index.blade.php ENDPATH**/ ?>