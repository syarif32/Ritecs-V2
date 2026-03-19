

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Detail & Moderasi Pesan</h2>
                
                <div class="mb-4 mt-3">
                    <?php if($comment->status == 'pending'): ?>
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-alert-triangle fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Pending (Menunggu)</h5>
                                <small>Pesan ini belum ditayangkan. Silakan balas atau ubah statusnya.</small>
                            </div>
                        </div>
                    <?php elseif($comment->status == 'approved'): ?>
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-check-circle fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Approved (Terbalas)</h5>
                                <small>Pesan ini sudah terbalas ke email user</small>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="fe fe-slash fe-24 mr-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0 font-weight-bold">Status: Spam</h5>
                                <small>Pesan ini terindikasi spam.</small>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">ID Pesan: #<?php echo e($comment->id); ?></strong>
                        <span class="badge badge-<?php echo e($comment->status == 'approved' ? 'success' : ($comment->status == 'spam' ? 'danger' : 'warning')); ?>">
                            Status: <?php echo e(ucfirst($comment->status)); ?>

                        </span>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Pengirim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light" value="<?php echo e($comment->name); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Pengirim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-mail"></i></span>
                                        </div>
                                        <input type="email" class="form-control bg-light" value="<?php echo e($comment->email); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nomor Telepon / WA</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-phone"></i></span>
                                        </div>
                                        
                                        <input type="text" class="form-control bg-light" value="<?php echo e($comment->phone ?? '-'); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Subjek Pesan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fe fe-tag"></i></span>
                                        </div>
                                        
                                        <input type="text" class="form-control bg-light" value="<?php echo e($comment->subject ?? 'Tidak ada subjek'); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="font-weight-bold">Isi Pesan / Aduan</label>
                            <textarea class="form-control bg-light" rows="5" readonly><?php echo e($comment->message); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-md-7">
                        <div class="card shadow mb-4 border-left-primary">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fe fe-mail mr-2"></i>Balas Pesan via Email</h5>
                                <p class="text-muted small">Balasan akan dikirim ke <strong><?php echo e($comment->email); ?></strong>. Status otomatis menjadi <strong>Approved</strong>.</p>
                                
                                <form action="<?php echo e(route('admin.comments.reply', $comment->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="reply_message">Isi Balasan Anda</label>
                                        <textarea name="reply_message" id="reply_message" class="form-control" rows="5" placeholder="Yth. <?php echo e($comment->name); ?>, terimakasih atas pesan Anda..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fe fe-send mr-1"></i> Kirim Balasan & Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Moderasi Manual</h5>
                                <p class="text-muted small">Ubah status tanpa mengirim email balasan.</p>
                                
                                <form action="<?php echo e(route('admin.comments.update', $comment->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="form-group">
                                        <label for="status">Ubah Status</label>
                                        <select id="status" name="status" class="form-control custom-select">
                                            <option value="pending" <?php echo e($comment->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                            <option value="approved" <?php echo e($comment->status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                                            <option value="spam" <?php echo e($comment->status == 'spam' ? 'selected' : ''); ?>>Spam</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-block">Simpan Status Saja</button>
                                </form>
                            </div>
                        </div>
                        
                        <a href="<?php echo e(route('admin.comments.index')); ?>" class="btn btn-outline-secondary btn-block mt-3">
                            <i class="fe fe-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/comments/edit.blade.php ENDPATH**/ ?>