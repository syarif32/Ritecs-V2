

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <h2 class="page-title">Bank Data</h2>
      <p class="card-text">List of banks data.</p>

      <a href="<?php echo e(route('admin.banks.create')); ?>" class="btn btn-primary mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add Bank
      </a>

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

          <table class="table datatables" id="dataTable-1">
            <thead>
              <tr>
                <th>Bank Name</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($bank->bank_name); ?></td>
                <td><?php echo e($bank->account_name); ?></td>
                <td><?php echo e($bank->account_number); ?></td>
                <td>
                  <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                    <span class="text-muted sr-only">Action</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?php echo e(route('admin.banks.edit',$bank->bank_id)); ?>">Edit</a>
                    <form action="<?php echo e(route('admin.banks.destroy',$bank->bank_id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus bank ini?')" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="dropdown-item text-danger">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>

          <?php echo e($banks->links()); ?>

        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/banks/index.blade.php ENDPATH**/ ?>