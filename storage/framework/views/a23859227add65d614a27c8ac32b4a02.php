<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Add Journal</h2>
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow mb-4">
            <div class="card-body position-relative">
              <form action="<?php echo e(route('admin.store-journals')); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-row">
                  <!-- Cover -->
                  <div class="form-group col-md-12">
                      <label for="coverImage" class="font-weight-bold">Journal Cover</label>
                      <div class="upload-box" id="uploadBox">
                          <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                          <img id="previewImage" 
                              src="<?php echo e(asset('assets/published/journals/journal_default.png')); ?>" 
                              alt="Preview" style="max-width: 150px;">
                      </div>
                  </div>

                  <!-- Title -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="title">Title</label>
                      <input type="text" id="title" name="title" class="form-control" required>
                  </div>

                  <!-- URL Path -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="url_path">Url Path</label>
                      <input type="text" id="url_path" name="url_path" class="form-control">
                  </div>

                  <!-- Keywords -->
                  <div class="col-12 position-relative">
                      <div class="form-group w-100 position-relative">
                          <label for="multi-select2">Category</label>
                          <select class="form-control select2-multi" name="keywords[]" id="multi-select2" multiple required>
                              <?php $__currentLoopData = $allKeywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($keyword->keyword_id); ?>"><?php echo e($keyword->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      </div>
                  </div>

                  <!-- Buttons -->
                  <div class="col-12 d-flex justify-content-start mt-3">
                      <button type="submit" class="btn btn-primary mr-2">Add Journal</button>
                      <a href="<?php echo e(route('admin.published-journals')); ?>" class="btn btn-secondary">Cancel</a>
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

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\published-journals\add-journal.blade.php ENDPATH**/ ?>