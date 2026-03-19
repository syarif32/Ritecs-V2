<?php $__env->startSection('content'); ?>

        <div class="container-fluid">

          <div class="row justify-content-center">
            <div class="col-12">

              <h2 class="page-title">Journal Data</h2>
              <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p>
              <a href="<?php echo e(route('admin.create-journals')); ?>" type="button" class="btn btn-primary pt-2"><span class="fe fe-file-plus fe-16 mr-2"></span>Add Journal</a>

              <div class="row my-4">
                <!-- Small table -->
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


                      <!-- table -->
                      <table class="table datatables" id="dataTable-1">
                        <thead>
                          <tr>
                            <th>Cover</th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Url Path</th>
                            <th>Category</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                  <a href="<?php echo e(asset($journal->cover_path)); ?>" target="_blank">
                                    <div class="avatar avatar-sm">
                                      <img src="<?php echo e(asset($journal->cover_path)); ?>" class="avatar-img rounded object-fit-cover">
                                    </div>
                                  </a>
                                </td>
                                <td><?php echo e($journal->journal_id); ?></td>
                                <td><?php echo e($journal->title); ?></td>
                                <td><a href="<?php echo e($journal->url_path); ?>" target="_blank"><?php echo e($journal->url_path); ?></a></td>
                                <td>
                                    <?php echo e($journal->keywords->pluck('name')->implode(', ') ?: '-'); ?>

                                </td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="<?php echo e(route('admin.edit-journals', $journal->journal_id)); ?>">Edit</a>
                                      <a class="dropdown-item" 
                                        href="<?php echo e(route('admin.delete-journals', $journal->journal_id)); ?>" 
                                        onclick="return confirm('Yakin mau dihapus?')">Remove
                                      </a>

                                    </div>
                                </td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div> <!-- simple table -->
              </div> <!-- end section -->
            </div> <!-- .col-12 -->
          </div> <!-- .row -->
        </div> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\published-journals\journal-data.blade.php ENDPATH**/ ?>