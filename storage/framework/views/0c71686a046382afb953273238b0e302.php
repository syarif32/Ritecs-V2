

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <h2 class="page-title">Edit Bank</h2>

      <div class="card shadow">
        <div class="card-body">
          <form method="POST" action="<?php echo e(route('admin.banks.update',$bank->bank_id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" name="bank_name" class="form-control" value="<?php echo e($bank->bank_name); ?>" required>
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" name="account_name" class="form-control" value="<?php echo e($bank->account_name); ?>" required>
            </div>
            <div class="form-group">
              <label>Account Number</label>
              <input type="text" name="account_number" class="form-control" value="<?php echo e($bank->account_number); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('admin.banks.index')); ?>" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/banks/edit.blade.php ENDPATH**/ ?>