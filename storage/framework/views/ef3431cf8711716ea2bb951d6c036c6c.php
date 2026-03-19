<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Edit Book</h2>
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow mb-4">
            <div class="card-body position-relative">
              <form action="<?php echo e(route('admin.update-books', $book->book_id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-row">
                  <!-- Cover -->
                  <div class="form-group col-md-12">
                      <label for="coverImage" class="font-weight-bold">Book Cover</label>
                      <div class="upload-box" id="uploadBox">
                          <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                          <img id="previewImage" 
                              src="<?php echo e(asset($book->cover_path)); ?>"
                              alt="Preview" style="max-width: 150px;">
                      </div>
                  </div>

                  <!-- Title -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="title">Title</label>
                      <input type="text" id="title" name="title" class="form-control" value="<?php echo e($book->title); ?>" required>
                  </div>

                  <!-- Publisher -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="publisher">Publisher</label>
                      <input type="text" id="publisher" name="publisher" class="form-control" value="<?php echo e($book->publisher); ?>">
                  </div>

                  <!-- ISBN -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="isbn">ISBN</label>
                      <input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo e($book->isbn); ?>">
                  </div>

                  <!-- Publish Date -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="publish_date">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" value="<?php echo e($book->publish_date); ?>">
                  </div>

                  <!-- Pages + Dimensi -->
                  <div class="form-group col-12 col-xl-12 mb-0">
                    <div class="form-row">
                      <div class="form-group col-6 col-xl-3">
                        <label for="pages">Pages</label>
                        <input type="number" id="pages" name="pages" class="form-control" value="<?php echo e($book->pages); ?>">
                      </div>
                      <div class="form-group col-6 col-xl-3">
                        <label for="width">Width (cm)</label>
                        <input type="number" step="0.01" id="width" name="width" class="form-control" value="<?php echo e($book->width); ?>">
                      </div>
                      <div class="form-group col-6 col-xl-3">
                        <label for="length">Length (cm)</label>
                        <input type="number" step="0.01" id="length" name="length" class="form-control" value="<?php echo e($book->length); ?>">
                      </div>
                      <div class="form-group col-6 col-xl-3">
                        <label for="thickness">Thickness (cm)</label>
                        <input type="number" step="0.01" id="thickness" name="thickness" class="form-control" value="<?php echo e($book->thickness); ?>">
                      </div>
                    </div>
                  </div>

                  <!-- Synopsis -->
                  <div class="form-group col-12">
                    <label for="Synopsis">Synopsis</label>
                    <textarea class="form-control py-1" id="Synopsis" name="Synopsis" rows="4"><?php echo e($book->synopsis); ?></textarea>
                  </div>

                  <!-- Category -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="category">Category</label>
                    <select class="form-control select2-multi" name="category[]" id="category" multiple required>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->category_id); ?>" <?php echo e($book->categories->contains($cat->category_id) ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>

                  <!-- Writer -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="writter">Writer</label>
                    <select class="form-control select2-multi" name="writter[]" id="writter" multiple required>
                        <?php $__currentLoopData = $writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($writer->writer_id); ?>" <?php echo e($book->writers->contains($writer->writer_id) ? 'selected' : ''); ?>>
                                <?php echo e($writer->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>

                  <!-- Price -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="print_price">Print Price</label>
                    <input type="number" id="print_price" name="print_price" class="form-control" value="<?php echo e($book->print_price); ?>">
                  </div>
                  <div class="form-group col-12 col-xl-6">
                    <label for="ebook_price">E Book Price</label>
                    <input type="number" id="ebook_price" name="ebook_price" class="form-control" value="<?php echo e($book->ebook_price); ?>">
                  </div>

                  <!-- Ebook Path -->
                  <div class="form-group col-12">
                      <label for="ebook_path">E Book Path</label>
                      <input type="text" id="ebook_path" name="ebook_path" class="form-control" value="<?php echo e($book->ebook_path); ?>">
                  </div>

                  <!-- Buttons -->
                  <div class="col-12 d-flex justify-content-start mt-3">
                      <button type="submit" class="btn btn-primary mr-2">Update Book</button>
                      <a href="<?php echo e(route('admin.published-books')); ?>" class="btn btn-secondary">Cancel</a>
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

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\published-books\edit-books.blade.php ENDPATH**/ ?>