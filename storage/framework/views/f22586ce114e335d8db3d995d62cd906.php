<?php $__env->startSection('content'); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <h2 class="page-title">Awarding Data</h2>
      <p class="card-text">
        DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the
        foundations of progressive enhancement, that adds all of these advanced features to any HTML table.
      </p>
      <a href="<?php echo e(route('admin.awardings.create')); ?>" type="button" class="btn btn-primary pt-2">
        <span class="fe fe-file-plus fe-16 mr-2"></span>Add Awarding
      </a>

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

              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead>
                  <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Penulis</th>
                    <th>Vol & No</th>
                    <th>Jenis Jurnal</th>
                    <th>Url Path</th>
                    <th>Keywords</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $awardings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td>
                      <?php if($award->cover_path): ?>
                      <a href="<?php echo e(asset($award->cover_path)); ?>" target="_blank">
                        <div class="avatar avatar-sm">
                          <img src="<?php echo e(asset($award->cover_path)); ?>"
                          class="avatar-img rounded cover"
                          style="width:30px; height:30px; object-fit:cover;">
                        </div>
                      </a>
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($award->title); ?></td>
                    <td><?php echo e($award->penulis); ?></td>
                    <td><?php echo e($award->volume_no); ?></td>
                    <td><?php echo e($award->jenis_jurnal); ?></td>
                    <td>
                      <?php if($award->url_path): ?>
                        <a href="<?php echo e($award->url_path); ?>" target="_blank"><?php echo e($award->url_path); ?></a>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php echo e($award->keywords->pluck('name')->implode(', ') ?: '-'); ?>

                    </td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"
                          href="<?php echo e(route('admin.awardings.edit', $award->awarding_id)); ?>">Edit</a>
                        <a class="dropdown-item"
                          href="<?php echo e(route('admin.awardings.destroy', $award->awarding_id)); ?>"
                          onclick="return confirm('Yakin mau dihapus?')">
                          Remove
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

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/awarding/awarding-data.blade.php ENDPATH**/ ?>