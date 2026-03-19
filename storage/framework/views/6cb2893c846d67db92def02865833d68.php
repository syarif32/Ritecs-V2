

<?php $__env->startSection('title', 'Permintaan Aktivasi Manual'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            
            <h2 class="mb-2 page-title">Permintaan Aktivasi Manual</h2>
            <p class="card-text">Daftar pengguna yang mengalami kendala verifikasi OTP. Tindakan Anda akan memverifikasi email mereka secara manual.</p>

            
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

            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            
                            
                            <?php if($requests->isEmpty()): ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle bg-light text-success">
                                                <i class="fe fe-check-circle fe-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="text-muted">Semua Aman!</h4>
                                    <p class="text-secondary">Tidak ada permintaan aktivasi yang tertunda saat ini.</p>
                                </div>
                            <?php else: ?>
                                
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pengguna</th>
                                            <th>Masalah / Alasan</th>
                                            <th>Waktu Request</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div>
                                                        <p class="mb-0 text-muted"><strong><?php echo e($req->user->first_name); ?> <?php echo e($req->user->last_name); ?></strong></p>
                                                        <small class="mb-0 text-muted"><?php echo e($req->user->email); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-danger font-italic">"<?php echo e($req->reason); ?>"</span>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?php echo e($req->created_at->diffForHumans()); ?></small>
                                            </td>
                                            <td class="text-right">
                                                
                                                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#approveModal-<?php echo e($req->id); ?>">
                                                    <i class="fe fe-check fe-12 mr-1"></i> Terima
                                                </button>

                                                
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#rejectModal-<?php echo e($req->id); ?>">
                                                    <i class="fe fe-x fe-12 mr-1"></i> Tolak
                                                </button>
                                            </td>
                                        </tr>

                                        
                                        <div class="modal fade" id="approveModal-<?php echo e($req->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success">
                                                            <i class="fe fe-check-circle mr-2"></i>Setujui Aktivasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?php echo e(route('admin.activation.approve', $req->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin <strong>mengaktifkan</strong> akun pengguna ini secara manual?</p>
                                                            
                                                            
                                                            <div class="card bg-light border-0 mb-3">
                                                                <div class="card-body p-2 d-flex align-items-center">
                                                                   
                                                                    <div>
                                                                        <div class="font-weight-bold"><?php echo e($req->user->first_name); ?> <?php echo e($req->user->last_name); ?></div>
                                                                        <small><?php echo e($req->user->email); ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="alert alert-warning small">
                                                                <i class="fe fe-info mr-1"></i> Status email user akan berubah menjadi <strong>Verified</strong> dan user dapat langsung login.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Ya, Aktifkan User</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="modal fade" id="rejectModal-<?php echo e($req->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger">
                                                            <i class="fe fe-x-circle mr-2"></i>Tolak Permintaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?php echo e(route('admin.activation.reject', $req->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <div class="modal-body">
                                                            <p>Anda akan menolak permintaan aktivasi untuk:</p>
                                                            
                                                           
                                                            <div class="card bg-light border-0 mb-3">
                                                                <div class="card-body p-2 d-flex align-items-center">
                                                                    <div class="avatar avatar-sm mr-3">
                                                                        <img src="<?php echo e($req->user->img_path ? asset($req->user->img_path) : asset('backend/assets/avatars/face-1.jpg')); ?>" class="avatar-img rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-weight-bold"><?php echo e($req->user->first_name); ?> <?php echo e($req->user->last_name); ?></div>
                                                                        <small class="text-muted"><?php echo e($req->reason); ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <p class="text-muted small">Permintaan ini akan ditandai sebagai 'Rejected' dan user tetap tidak bisa login.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                        </div> 
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/activation/index.blade.php ENDPATH**/ ?>