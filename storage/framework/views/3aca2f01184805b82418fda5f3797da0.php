

<?php $__env->startSection('title', 'Role Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">Role Management</h2>
            <p class="card-text">Kelola hak akses administrator sistem. Gunakan fitur ini dengan bijak.</p>

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

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
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
                                        <td>
                                            <?php if($user->acc_status == 1): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e($user->created_at->format('d M Y')); ?></small>
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

                                    <div class="modal fade" id="promoteModal-<?php echo e($user->user_id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hak Akses</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?php echo e(route('admin.users.promote', $user->user_id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <div class="modal-body">
                                                        <div class="alert alert-warning">
                                                            <i class="fe fe-alert-triangle mr-2"></i> <strong>Tindakan Sensitif!</strong>
                                                        </div>
                                                        <p>Anda akan memberikan akses penuh <strong>ADMINISTRATOR</strong> kepada:</p>
                                                        <div class="card bg-light border-0 mb-3">
                                                            <div class="card-body p-2 d-flex align-items-center">
                                                                <div class="avatar avatar-sm mr-3">
                                                                    <img src="<?php echo e($user->img_path ? asset($user->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" class="avatar-img rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></div>
                                                                    <small><?php echo e($user->email); ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Masukkan Password Anda untuk konfirmasi:</label>
                                                            <input type="password" class="form-control" name="admin_password" required placeholder="Password Login Anda">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Ya, Jadikan Admin</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="demoteModal-<?php echo e($user->user_id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">Cabut Hak Akses</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?php echo e(route('admin.users.demote', $user->user_id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <div class="modal-body">
                                                        <p>Anda yakin ingin mencabut akses <strong>ADMIN</strong> dari pengguna ini?</p>
                                                        <div class="card bg-light border-0 mb-3">
                                                            <div class="card-body p-2">
                                                                <strong><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></strong><br>
                                                                <small><?php echo e($user->email); ?></small>
                                                            </div>
                                                        </div>
                                                        <p class="text-muted small">Pengguna akan kembali menjadi User biasa.</p>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Konfirmasi Password Anda:</label>
                                                            <input type="password" class="form-control" name="admin_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Cabut Akses</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> </div> </div> </div> </div> <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/usersmanagement/index.blade.php ENDPATH**/ ?>