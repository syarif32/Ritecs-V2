<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Edit Awarding</h2>
      <p class="text-muted">Form untuk memperbarui data awarding</p>

      <div class="row">
        <div class="col-md-8">

          <div class="card shadow mb-4">
            <div class="card-body position-relative">
              
              <form action="<?php echo e(route('admin.awardings.update', $award->awarding_id)); ?>" 
                  method="POST" enctype="multipart/form-data" 
                  class="needs-validation" novalidate>
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('PUT'); ?>

                  <div class="form-row">
                      <!-- Cover -->
                      <div class="form-group col-md-12">
                          <label for="coverImage" class="font-weight-bold">Awarding Cover</label>
                          <div class="upload-box" id="uploadBox">
                              <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                              <img id="previewImage" 
                                  src="<?php echo e($award->cover_path ? asset($award->cover_path) : asset('assets/published/awards/award_default.png')); ?>" 
                                  alt="Preview" style="max-width: 150px;">
                          </div>
                      </div>

                      <!-- Title -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="title">Title</label>
                          <input type="text" id="title" name="title" 
                                value="<?php echo e($award->title); ?>" class="form-control" required>
                      </div>

                      <!-- Penulis -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="penulis">Penulis</label>
                          <input type="text" id="penulis" name="penulis" 
                                value="<?php echo e($award->penulis); ?>" class="form-control">
                      </div>

                      <!-- Abstract -->
                      <div class="form-group col-12">
                          <label for="abstract">Abstract</label>
                          <textarea id="abstract" name="abstract" 
                                    class="form-control" rows="4"><?php echo e($award->abstract); ?></textarea>
                      </div>

                      <!-- Volume -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="volume_no">Volume No</label>
                          <input type="text" id="volume_no" name="volume_no" 
                                value="<?php echo e($award->volume_no); ?>" class="form-control">
                      </div>

                      <!-- Jenis Jurnal -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="jenis_jurnal">Jenis Jurnal</label>
                          <input type="text" id="jenis_jurnal" name="jenis_jurnal" 
                                value="<?php echo e($award->jenis_jurnal); ?>" class="form-control">
                      </div>

                      <!-- URL Path -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="url_path">Url Path</label>
                          <input type="text" id="url_path" name="url_path" 
                                value="<?php echo e($award->url_path); ?>" class="form-control">
                      </div>

                      <!-- Keywords -->
                      <div class="col-12 col-xl-6 position-relative">
                          <div class="form-group w-100 position-relative">
                              <label for="multi-select2">Keyword</label>
                              <select class="form-control select2-multi" 
                                      name="keywords[]" id="multi-select2" multiple>
                                  <?php $__currentLoopData = $allKeywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <option value="<?php echo e($keyword->keyword_id); ?>" 
                                          <?php echo e(in_array($keyword->keyword_id, $award->keywords->pluck('keyword_id')->toArray()) ? 'selected' : ''); ?>>
                                          <?php echo e($keyword->name); ?>

                                      </option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                          </div>
                      </div>

                      <!-- Buttons -->
                      <div class="col-12 d-flex justify-content-start mt-3">
                          <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                          <a href="<?php echo e(route('admin.awardings.index')); ?>" class="btn btn-secondary">Cancel</a>
                      </div>
                  </div>
              </form>

              
            </div>
          </div>

        </div>
      </div> 

    </div>
  </div>
</div> <!-- .container-fluid -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\awarding\edit-awarding.blade.php ENDPATH**/ ?>