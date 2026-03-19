

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-8">
      <h2 class="page-title">Add Writer</h2>
      <div class="card shadow mb-4">
        <div class="card-body">

          
          <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show">
              <?php echo e(session('warning')); ?>

              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>

          <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>

          <form id="writerForm" action="<?php echo e(route('admin.writers.store', ['redirect' => 'writers'])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div id="writer-fields">
              <label>Writer Name</label>
              <div class="form-group">
                <div class="row p-0 m-0 g-2">
                  <div class="col-12 col-md-5 px-0 py-1 p-md-0 pr-md-3">
                    <input type="text" class="form-control" name="names[]" required>
                  </div>
                  <div class="col-12 col-md-5 px-0 py-1 p-md-0 pr-md-3">
                    <select class="form-control" name="user_ids[]">
                      <option value="">-- User Relations (opsional) --</option>
                      <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->user_id); ?>"><?php echo e($user->full_name); ?> - <?php echo e($user->email); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 px-0 py-2 p-md-0 ">
                    <button type="button" class="btn btn-outline-primary w-100" onclick="addField(event)">+1 item</button>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('admin.writers')); ?>" class="btn btn-secondary">Back</a>
          </form>

          <script>
            function addField(e) {
              e.preventDefault();
              let div = document.createElement('div');
              div.classList.add('form-group');
              div.innerHTML = `
                <div class="row p-0 m-0 g-2">
                  <div class="col-12 col-md-5 p-0 m-0 pr-3">
                    <input type="text" class="form-control" name="names[]" required>
                  </div>
                  <div class="col-12 col-md-5 p-0 m-0 pr-3">
                    <select class="form-control" name="user_ids[]">
                        <option value="">-- User Relations (opsional) --</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->user_id); ?>"><?php echo e($user->full_name); ?> - <?php echo e($user->email); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 p-0 m-0">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.form-group').remove()">Delete</button>
                  </div>
                </div>
              `;
              document.getElementById('writer-fields').appendChild(div);
            }

            // cek duplikat sebelum submit
            document.getElementById('writerForm').addEventListener('submit', function(e) {
              let inputs = document.querySelectorAll('input[name="names[]"]');
              let values = [];
              let duplicate = false;

              inputs.forEach(input => {
                let val = input.value.trim().toLowerCase();
                if (values.includes(val)) {
                  duplicate = true;
                  $(input).attr("data-toggle", "popover")
                          .attr("data-placement", "bottom")
                          .attr("data-content", "Nama writer duplikat!")
                          .popover("show");
                } else {
                  values.push(val);
                  $(input).popover("dispose");
                }
              });

              if (duplicate) e.preventDefault();
            });
          </script>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/writers/create.blade.php ENDPATH**/ ?>