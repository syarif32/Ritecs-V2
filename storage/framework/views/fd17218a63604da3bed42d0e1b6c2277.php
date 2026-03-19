

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <h2 class="page-title">Add Bank</h2>

      <div class="card shadow">
        <div class="card-body">
          <form method="POST" action="<?php echo e(route('admin.banks.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" name="bank_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" name="account_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Account Number</label>
              <input type="text" name="account_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('admin.banks.index')); ?>" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/banks/create.blade.php ENDPATH**/ ?>