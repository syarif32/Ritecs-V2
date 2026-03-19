

<?php $__env->startSection('title', 'History Log'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">History Log</h2>
            <p class="card-text">Catatan riwayat aktivitas promosi dan demosi administrator.</p>

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-hover datatables" id="dataTable-1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Waktu Kejadian</th>
                                        <th>Admin (Pelaku)</th>
                                        <th>Jenis Aksi</th>
                                        <th>Target User</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        
                                        <td>
                                            <div class="text-dark"><?php echo e($log->created_at->format('d M Y')); ?></div>
                                            <small class="text-muted"><?php echo e($log->created_at->format('H:i')); ?> WIB</small>
                                        </td>

                                        
                                        <td>
                                            <?php if($log->actor): ?>
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="<?php echo e($log->actor->img_path ? asset($log->actor->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        
                                                        <strong class="text-dark"><?php echo e($log->actor->email); ?></strong>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted font-italic">(User Terhapus)</span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <?php if($log->action_type == 'PROMOTE'): ?>
                                                <span class="badge badge-pill badge-success">
                                                    <i class="fe fe-arrow-up mr-1"></i> Promote
                                                </span>
                                            <?php elseif($log->action_type == 'DEMOTE'): ?>
                                                <span class="badge badge-pill badge-danger">
                                                    <i class="fe fe-arrow-down mr-1"></i> Demote
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-secondary"><?php echo e($log->action_type); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <?php if($log->target): ?>
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="<?php echo e($log->target->img_path ? asset($log->target->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <span><?php echo e($log->target->first_name); ?> <?php echo e($log->target->last_name); ?></span><br>
                                                        <small class="text-muted"><?php echo e($log->target->email); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted font-italic">User ID: <?php echo e($log->target_id); ?> (Terhapus)</span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <span class="text-muted small"><?php echo e($log->description); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-clipboard fe-24 mb-2 d-block"></i>
                                                Belum ada aktivitas log yang tercatat.
                                            </div>
                                        </td>
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
    </div> 
</div> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/usersmanagement/history.blade.php ENDPATH**/ ?>