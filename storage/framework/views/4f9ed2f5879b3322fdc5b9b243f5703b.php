

<?php $__env->startSection('title', 'Riwayat Aktivitas Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title">Riwayat Aktivitas Role</h2>
                    <p class="text-muted">Catatan perubahan status Admin dan User.</p>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Waktu</th>
                                <th>Admin (Pelaku)</th>
                                <th>Aksi</th>
                                <th>Target User</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php echo e($log->created_at->format('d M Y, H:i')); ?>

                                    <br>
                                    <small class="text-muted"><?php echo e($log->created_at->diffForHumans()); ?></small>
                                </td>
                                <td>
                                    <?php if($log->actor): ?>
                                        <strong><?php echo e($log->actor->first_name); ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">Sistem / Terhapus</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($log->action_type == 'PROMOTE'): ?>
                                        <span class="badge badge-success">PROMOTION</span>
                                    <?php elseif($log->action_type == 'DEMOTE'): ?>
                                        <span class="badge badge-danger">DEMOTION</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><?php echo e($log->action_type); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($log->target): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs mr-2">
                                                <img src="<?php echo e($log->target->img_path ? asset($log->target->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" class="avatar-img rounded-circle">
                                            </div>
                                            <span><?php echo e($log->target->first_name); ?></span>
                                        </div>
                                        <small class="text-muted"><?php echo e($log->target->email); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">User Terhapus</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($log->description); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada riwayat aktivitas.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                <?php echo e($logs->links()); ?>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\usersmanagement\history.blade.php ENDPATH**/ ?>