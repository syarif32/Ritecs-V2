<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-6">
      <h2 class="page-title">Add Keyword</h2>
      <div class="card shadow mb-4">
        <div class="card-body">

          
          <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?php echo e(session('warning')); ?>

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

          <form id="keywordForm" action="<?php echo e(route('admin.keywords.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div id="keyword-fields">
              <label for="name">Keyword Name</label>
              <div class="form-group">
                <div class="row p-0 m-0 g-2">
                  <div class="col-12 col-md-10 px-0 py-1 p-md-0 pr-md-3">
                    <input type="text" class="form-control" name="names[]" required>
                  </div>
                  <div class="col-12 col-md-2 p-0 m-0">
                    <button type="button" class="btn btn-outline-primary w-100" onclick="addField(event)">+1 item</button>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('admin.keywords')); ?>" class="btn btn-secondary">Cancel</a>
          </form>

          <script>
            function addField(e) {
                e.preventDefault();
                let div = document.createElement('div');
                div.classList.add('form-group');
                div.innerHTML = `
                    <div class="row p-0 m-0 g-2">
                        <div class="col-12 col-md-10 px-0 py-1 p-md-0 pr-md-3">
                            <input type="text" class="form-control" name="names[]" required>
                        </div>
                        <div class="col-12 col-md-2 p-0 m-0">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.form-group').remove()">Delete</button>
                        </div>
                    </div>
                `;
                document.getElementById('keyword-fields').appendChild(div);
            }

            // Cek duplikat sebelum submit (client-side)
            document.getElementById('keywordForm').addEventListener('submit', function(e) {
                let inputs = document.querySelectorAll('input[name="names[]"]');
                let values = [];
                let duplicate = false;

                inputs.forEach(input => {
                    let val = input.value.trim().toLowerCase();
                    if (values.includes(val)) {
                        duplicate = true;
                        $(input).attr("data-toggle", "popover")
                            .attr("data-placement", "bottom")
                            .attr("data-content", "Keyword duplikat!")
                            .popover("show");
                    } else {
                        values.push(val);
                        $(input).popover("dispose");
                    }
                });

                if (duplicate) {
                    e.preventDefault();
                }
            });
          </script>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\keywords\create.blade.php ENDPATH**/ ?>