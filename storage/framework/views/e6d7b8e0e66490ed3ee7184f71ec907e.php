<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Inactive Transactions</h2>
      <p class="card-text">Daftar transaksi yang dinonaktifkan. Anda bisa memulihkannya kembali.</p>

      <div class="row my-4">
        <div class="col-md-12">
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

              <table class="table datatables" id="dataTable-1">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Sender Name</th>
                    <th>Sender Bank</th>
                    <th>Destination</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($tx->transaction_id); ?></td>
                    <td><?php echo e($tx->user->full_name ?? '-'); ?></td>
                    <td>Rp. <?php echo e(number_format($tx->amount, 0, ',', '.')); ?></td>
                    <td><?php echo e($tx->sender_name); ?></td>
                    <td><?php echo e($tx->sender_bank); ?></td>
                    <td><?php echo e($tx->bank->bank_name ?? '-'); ?> - <?php echo e($tx->bank->account_number ?? '-'); ?></td>
                    <td>
                      <?php if($tx->proof_path): ?>
                        <a href="<?php echo e(asset($tx->proof_path)); ?>" target="_blank">
                          <img src="<?php echo e(asset($tx->proof_path)); ?>" style="max-width:50px;" class="rounded">
                        </a>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($tx->status === 'paid'): ?>
                        <span class="badge badge-pill badge-success h6">Paid</span>
                      <?php elseif($tx->status === 'pending'): ?>
                        <span class="badge badge-pill badge-warning h6">Pending</span>
                      <?php elseif($tx->status === 'rejected'): ?>
                        <span class="badge badge-pill badge-danger h6">Rejected</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($tx->updated_at->format('d M Y H:i')); ?></td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropd own-menu-right">
                        <a class="dropdown-item"
                          href="<?php echo e(route('admin.memberships.edit', $tx->transaction_id)); ?>"
                          <?php if($tx->status === 'paid'): ?>
                              onclick="return confirm('Transaksi ini berstatus PAID. Mengubah data dapat menyebabkan inkonsistensi. Apakah Anda yakin ingin melanjutkan?')"
                          <?php endif; ?>
                        >
                          Edit
                        </a>

                        <a class="dropdown-item text-success"
                            href="<?php echo e(route('admin.memberships.restore', $tx->transaction_id)); ?>"
                            onclick="return confirm('Pulihkan transaksi ini beserta status membership user terkait?')">
                            Restore
                        </a>
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\memberships\memberships-trashed.blade.php ENDPATH**/ ?>