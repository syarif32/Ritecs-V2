

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Book Data</h2>
      <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool for advanced table features.</p>
      
      <a href="<?php echo e(route('admin.create-books')); ?>" type="button" class="btn btn-primary pt-2 mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span>Add Book
      </a>

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

              <table class="table datatables" id="dataTable-1">
                <thead>
                  <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Writer</th>
                    <th>Category</th>
                    <th>Publisher</th>
                    <th>Pages</th>
                    <th>W x L x T</th>
                    <th>ISBN</th>
                    <th>Ebook Path</th>
                    <th>Print Price</th>
                    <th>Ebook Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td>
                      <a href="<?php echo e(asset($book->cover_path)); ?>" target="_blank">
                        <div class="avatar avatar-sm">
                          <img src="<?php echo e(asset($book->cover_path)); ?>" class="avatar-img rounded object-fit-cover">
                        </div>
                      </a>
                    </td>
                    <td class="small"><?php echo e($book->title); ?></td>
                    <td class="small">
                     <?php if($book->writers->count() > 0): ?>
                        <?php $__currentLoopData = $book->writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php echo e($index + 1); ?>. <?php echo e($writer->name); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td class="small">
                      <?php echo e($book->categories->pluck('name')->implode(', ')); ?>

                    </td>
                    <td class="small"><?php echo e($book->publisher); ?></td>
                    <td class="small"><?php echo e($book->pages); ?></td>
                    <td class="small">
                      <?php if($book->width || $book->length || $book->thickness): ?>
                        <?php echo e($book->width ?? '-'); ?> x <?php echo e($book->length ?? '-'); ?> x <?php echo e($book->thickness ?? '-'); ?> cm
                      <?php endif; ?>
                    </td>
                    <td class="small"><?php echo e($book->isbn); ?></td>
                    <td class="small">
                      <?php if($book->ebook_path): ?>
                        <a href="<?php echo e($book->ebook_path); ?>" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;"><?php echo e($book->ebook_path); ?></a>
                      <?php endif; ?>
                    </td>
                    <td class="small">
                      <?php if($book->print_price): ?> Rp. <?php echo e(number_format($book->print_price, 0, ',', '.')); ?> <?php endif; ?>
                    </td>
                    <td class="small">
                      <?php if($book->ebook_price): ?> Rp. <?php echo e(number_format($book->ebook_price, 0, ',', '.')); ?> <?php endif; ?>
                    </td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo e(route('admin.edit-books', $book->book_id)); ?>">Edit</a>
                        <a class="dropdown-item" 
                          href="<?php echo e(route('admin.delete-books', $book->book_id)); ?>" 
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
        </div> 
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/published-books/books-data.blade.php ENDPATH**/ ?>