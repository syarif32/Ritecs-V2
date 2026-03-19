

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Data Komentar & Aduan</h2>
      <div class="card shadow">
        <div class="card-body">
          
          
          <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo e(session('success')); ?>

              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>
          <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo e(session('error')); ?>

              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>
          <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>

          <div class="table-responsive">
            <table class="table datatables table-hover" id="dataTable-1">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Subjek</th> 
                    <th>Email</th>
                    <th width="20%">Pesan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td class="font-weight-bold"><?php echo e($comment->name); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::limit($comment->subject ?? '-', 20)); ?></td> 
                        <td><?php echo e($comment->email); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::limit($comment->message, 40)); ?></td>
                        <td>
                            <?php if($comment->status == 'approved'): ?>
                            <span class="badge badge-success">Approved</span>
                            <?php elseif($comment->status == 'pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Spam</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($comment->created_at->format('d M Y')); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    id="action-<?php echo e($comment->id); ?>" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="action-<?php echo e($comment->id); ?>">
                                    
                                    
                                    <a class="dropdown-item font-weight-bold text-primary" href="<?php echo e(route('admin.comments.edit', $comment->id)); ?>">
                                        <i class="fe fe-eye mr-2"></i> Lihat & Balas
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>

                                    <?php if($comment->status != 'approved'): ?>
                                    <form action="<?php echo e(route('admin.comments.updateStatus', $comment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="dropdown-item"><i class="fe fe-check mr-2"></i> Approve</button>
                                    </form>
                                    <?php endif; ?>

                                    <?php if($comment->status != 'spam'): ?>
                                    <form action="<?php echo e(route('admin.comments.updateStatus', $comment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="status" value="spam">
                                        <button type="submit" class="dropdown-item"><i class="fe fe-slash mr-2"></i> Tandai Spam</button>
                                    </form>
                                    <?php endif; ?>

                                    <div class="dropdown-divider"></div>
                                
                                    <form action="<?php echo e(route('admin.comments.destroy', $comment->id)); ?>" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini secara permanen?');">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item text-danger"><i class="fe fe-trash-2 mr-2"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/comments/index.blade.php ENDPATH**/ ?>