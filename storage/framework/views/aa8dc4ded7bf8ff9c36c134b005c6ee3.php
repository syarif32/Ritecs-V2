<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12">

      <h2 class="page-title">Membership Data</h2>
      <p class="card-text">List of membership user data.</p>

      <a href="<?php echo e(route('admin.manageUserMemberships.create')); ?>" class="btn btn-primary mb-3" onclick="return confirm('Menambahkan data membership tanpa transaksi akan menyebabkan inkonsistensi data!')">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add Membership</a>

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
                    <th>Member Number</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Period Start - End</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($m->member_number); ?></td>
                    <td>
                      <?php if($m->user): ?>
                        <?php echo e($m->user->full_name); ?>

                      <?php else: ?>
                        <?php echo e($m->guest_first_name); ?> <?php echo e($m->guest_last_name); ?>

                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($m->user): ?>
                        <?php echo e($m->user->email); ?>

                      <?php else: ?>
                        <?php echo e($m->guest_email); ?>

                      <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($m->user->nik)): ?>
                          <?php echo e($m->user->nik); ?>

                        <?php else: ?>
                          <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                        <?php endif; ?>

                    </td>
                    <td>
                      <?php
                        $now = now();
                        if($m->start_date <= $now && $m->end_date >= $now){
                            $icon = '<span class="fe fe-10 fe-check text-dark mr-2 bg-success rounded-pill"></span>
                                    <span class="text-success">' . $m->start_date . ' - ' . $m->end_date . '</span>';
                        } else {
                            $icon = '<span class="fe fe-10 fe-x text-dark mr-2 bg-warning rounded-pill"></span>
                                    <span class="text-warning">' . $m->start_date . ' - ' . $m->end_date . '</span>';
                        }
                      ?>
                      <?php echo $icon; ?>

                    </td>


                    <td>
                      <?php
                        $badge = $m->status == 1 ? 'success' : 'danger';
                        $label = $m->status == 1 ? 'Active' : 'Inactive';
                      ?>
                      <span class="pt-1 badge badge-<?php echo e($badge); ?>"><?php echo e($label); ?></span>
                    </td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo e(route('admin.manageUserMemberships.edit',$m->membership_id)); ?>">Edit</a>
                        <?php if($m->status == 1): ?>
                        <a class="dropdown-item text-warning" 
                          href="<?php echo e(route('admin.manageUserMemberships.destroy',$m->membership_id)); ?>" 
                          onclick="return confirm('Deactivate this membership?')">Deactivate</a>
                        <?php else: ?>
                        <a class="dropdown-item text-success" 
                          href="<?php echo e(route('admin.manageUserMemberships.restore',$m->membership_id)); ?>">Activate</a>
                        <?php endif; ?>
                         <a class="dropdown-item text-danger" 
                          href="<?php echo e(route('admin.manageUserMemberships.forceDelete',$m->membership_id)); ?>" 
                          onclick="return confirm('Yakin ingin menghapus data membership ini?') && confirm('Menghapus data membership akan menyebabkan inkonsistensi data user dengan langganan. Lanjutkan?')"
                          >Remove</a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>

              <?php echo e($memberships->links()); ?>

            </div>
          </div>
        </div> 
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\manage-user-membership\index.blade.php ENDPATH**/ ?>