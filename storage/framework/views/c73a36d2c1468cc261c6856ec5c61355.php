<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-lg-10 col-xl-8">
      <h2 class="h3 mb-4 page-title">Edit Membership</h2>

      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="<?php echo e(route('admin.manageUserMemberships.update',$membership->membership_id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>User</label>
                <select name="user_id" class="form-control" disabled>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($u->user_id); ?>" <?php echo e($membership->user_id == $u->user_id ? 'selected' : ''); ?>>
                    <?php echo e($u->full_name); ?>

                  </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="1" <?php echo e($membership->status == 1 ? 'selected' : ''); ?>>Active</option>
                  <option value="0" <?php echo e($membership->status == 0 ? 'selected' : ''); ?>>Inactive</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label>Start Date</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo e($membership->start_date); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label>End Date</label>
                <input type="date" class="form-control" name="end_date" value="<?php echo e($membership->end_date); ?>">
              </div>
              
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
            <a href="<?php echo e(route('admin.manageUserMemberships.index')); ?>" class="btn btn-secondary">Cancel</a>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\manage-user-membership\edit.blade.php ENDPATH**/ ?>