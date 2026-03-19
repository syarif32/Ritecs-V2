<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-6">
      <h2 class="page-title">Edit Category</h2>
      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="<?php echo e(route('admin.categories.update', $category->category_id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
              <label for="name">Category Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo e($category->name); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('admin.categories')); ?>" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\categories\edit.blade.php ENDPATH**/ ?>