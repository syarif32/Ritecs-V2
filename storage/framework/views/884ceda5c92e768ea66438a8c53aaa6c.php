<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Verify Transaction</h2>
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow mb-4">
            <div class="card-body position-relative">

              <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2">
                  <?php echo e(session('success')); ?>

                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php endif; ?>

              <form action="<?php echo e(route('admin.memberships.update', $transaction->transaction_id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-row">

                  <div class="form-group col-12">
                    <label>User</label>
                    <input type="text" class="form-control" value="<?php echo e($transaction->user->full_name ?? '-'); ?>" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Amount</label>
                    <input type="text" class="form-control" value="Rp. <?php echo e(number_format($transaction->amount,0,',','.')); ?>" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Sender Name</label>
                    <input type="text" class="form-control" value="<?php echo e($transaction->sender_name); ?>" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Sender Bank</label>
                    <input type="text" class="form-control" value="<?php echo e($transaction->sender_bank); ?>" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Destination</label>
                    <input type="text" class="form-control" value="<?php echo e($transaction->bank->bank_name ?? 'Bank name error'); ?> - <?php echo e($transaction->bank->account_number ?? 'Account number error'); ?>" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Proof</label>
                    <?php if($transaction->proof_path): ?>
                      <a href="<?php echo e(asset($transaction->proof_path)); ?>" target="_blank">
                        <img src="<?php echo e(asset($transaction->proof_path)); ?>" style="max-width:150px;" class="rounded">
                      </a>
                    <?php endif; ?>
                  </div>

                  <div class="form-group col-12">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                      <option value="pending" <?php echo e($transaction->status==='pending'?'selected':''); ?>>Pending</option>
                      <option value="paid" <?php echo e($transaction->status==='paid'?'selected':''); ?>>Paid</option>
                      <option value="rejected" <?php echo e($transaction->status==='rejected'?'selected':''); ?>>Rejected</option>
                    </select>
                  </div>

                  <div class="col-12 d-flex justify-content-start mt-3">
                      <button type="submit" class="btn btn-primary mr-2">Update Status</button>
                      <a href="<?php echo e(route('admin.memberships')); ?>" class="btn btn-secondary">Cancel</a>
                  </div>

                </div>
              </form>

            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\memberships\edit-memberships.blade.php ENDPATH**/ ?>