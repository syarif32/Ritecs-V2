<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <h2 class="page-title">User Data</h2>
      <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool for advanced table features.</p>


      <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span> Add User</a>

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
                  <th>Profile</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>NIK</th>
                  <th>Acc Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td>
                    <a href="<?php echo e(asset($user->img_path)); ?>" target="_blank">
                      <div class="avatar avatar-sm">
                        <img src="<?php echo e(asset($user->img_path)); ?>" class="avatar-img rounded cover"
                        style="width:30px; height:30px; object-fit:cover;">
                      </div>
                    </a>
                  </td>
                  <td>
                    <?php if(!empty($user->full_name)): ?>
                      <?php echo e($user->full_name); ?>

                    <?php else: ?>
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if(!empty($user->email)): ?>
                      <?php echo e($user->email); ?>

                    <?php else: ?>
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if(!empty($user->phone)): ?>
                      <?php echo e($user->phone); ?>

                    <?php else: ?>
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if(!empty($user->nik)): ?>
                      <?php echo e($user->nik); ?>

                    <?php else: ?>
                      <span class="pt-1 badge badge-pill badge-secondary">Unset</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php
                        // Account Status
                        $accStatus = $user->acc_status == 1 ? 'Active' : 'Nonactive';
                        $accColor  = $user->acc_status == 1 ? 'success' : 'warning';
                    ?>

                    <span class="pt-1 badge badge-pill badge-<?php echo e($accColor); ?>">
                        <?php echo e($accStatus); ?>

                    </span>
                  </td>


                  <td>
                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="<?php echo e(route('admin.users.edit',$user->user_id)); ?>">Edit</a>
                      <?php if($user->acc_status == 1): ?>
                      <a class="dropdown-item text-danger" 
                        href="<?php echo e(route('admin.users.destroy',$user->user_id)); ?>" 
                        onclick="return confirm('Yakin ingin menonaktifkan User?')">Nonactive
                      </a>
                      <?php else: ?>
                      <a class="dropdown-item text-success" href="<?php echo e(route('admin.users.restore',$user->user_id)); ?>">Activate</a>
                      <?php endif; ?>
                    </div>
                  </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
            <?php echo e($users->links()); ?>

          </div>
        </div>
        </div>
      </div>
      

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/users/nonactiveusers-data.blade.php ENDPATH**/ ?>