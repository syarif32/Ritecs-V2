

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Writers</h2>
      <a href="<?php echo e(route('admin.writers.create')); ?>" class="btn btn-primary mb-3">+ Add Writer</a>
      <div class="card shadow">
        <div class="card-body">
          
          <?php if(session('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
          <?php endif; ?>

          <table class="table datatables" id="dataTable-1">
            <thead>
              <tr>
                <th>ID</th>
                <th>Writer Name</th>
                <th>ID - User Relation</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td><?php echo e($writer->writer_id); ?></td>
                <td><?php echo e($writer->name); ?></td>
                <td><?php echo e($writer->user ? $writer->user->user_id : ''); ?> - <?php echo e($writer->user ? $writer->user->full_name : 'Unrelated'); ?></td>
                <td><?php echo e($writer->created_at); ?></td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="<?php echo e(route('admin.writers.edit', $writer->writer_id)); ?>">Edit</a>
                      <a class="dropdown-item" href="<?php echo e(route('admin.writers.delete', $writer->writer_id)); ?>" 
                        onclick="return confirm('Yakin hapus writer ini?')">Delete</a>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/writers/index.blade.php ENDPATH**/ ?>