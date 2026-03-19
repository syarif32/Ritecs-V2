

<?php $__env->startSection('title', 'Content History Log'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <h2 class="mb-2 page-title">Content Publishing History</h2>
            <p class="card-text">Riwayat aktivitas unggahan Buku, Jurnal, dan Awarding oleh Admin.</p>

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-hover datatables" id="dataTable-1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Admin (Pelaku)</th>
                                        <th>Aksi</th>
                                        <th>Tipe Konten</th>
                                        <th>Deskripsi Aktivitas</th>
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
                                            <?php if($log->user): ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm mr-2">
                                                        <img src="<?php echo e($log->user->img_path ? asset($log->user->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" 
                                                             alt="..." 
                                                             class="avatar-img rounded-circle"
                                                             style="object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <strong class="text-dark"><?php echo e($log->user->email); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($log->user->first_name); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted font-italic">Admin Terhapus</span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <?php if($log->action == 'CREATE'): ?>
                                                <span class="badge badge-pill badge-success">
                                                    <i class="fe fe-plus mr-1"></i> Upload
                                                </span>
                                            <?php elseif($log->action == 'UPDATE'): ?>
                                                <span class="badge badge-pill badge-warning text-white">
                                                    <i class="fe fe-edit mr-1"></i> Edit
                                                </span>
                                            <?php elseif($log->action == 'DELETE'): ?>
                                                <span class="badge badge-pill badge-danger">
                                                    <i class="fe fe-trash mr-1"></i> Hapus
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <?php if(str_contains($log->content_type, 'Book')): ?>
                                                <span class="badge badge-light border border-secondary text-secondary">
                                                    <i class="fas fa-book mr-1"></i> Buku
                                                </span>
                                            <?php elseif(str_contains($log->content_type, 'Journal')): ?>
                                                <span class="badge badge-light border border-primary text-primary">
                                                    <i class="fas fa-newspaper mr-1"></i> Jurnal
                                                </span>
                                            <?php elseif(str_contains($log->content_type, 'Awarding')): ?>
                                                <span class="badge badge-light border border-warning text-warning">
                                                    <i class="fas fa-trophy mr-1"></i> Award
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary"><?php echo e(class_basename($log->content_type)); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td>
                                            <span class="text-dark small"><?php echo e($log->description); ?></span>
                                            <br>
                                            <small class="text-muted">ID Konten: <?php echo e($log->content_id); ?></small>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-clipboard fe-24 mb-2 d-block"></i>
                                                Belum ada riwayat publikasi.
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
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/logs/content-history.blade.php ENDPATH**/ ?>