

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Add Book</h2>
        <div class="row">
        <div class="col-md-8">
          <div class="card shadow mb-4">
            <div class="card-body position-relative">
              <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2">
                  <?php echo e(session('success')); ?>

                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php endif; ?>

              <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show mt-2">
                  <?php echo e(session('warning')); ?>

                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php endif; ?>
              <form action="<?php echo e(route('admin.store-books')); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-row">
                  <!-- Cover -->
                  <div class="form-group col-md-12">
                      <label for="coverImage" class="font-weight-bold">Book Cover</label>
                      <div class="upload-box" id="uploadBox">
                          <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                          <img id="previewImage" 
                              src="<?php echo e(asset('assets/published/books/book_default.png')); ?>"
                              alt="Preview" style="max-width: 150px;">
                      </div>
                  </div>

                  <!-- Title -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="title">Title</label>
                      <input type="text" id="title" name="title" class="form-control" required>
                  </div>

                  <!-- Publisher -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="publisher">Publisher</label>
                      <input type="text" id="publisher" name="publisher" class="form-control">
                  </div>

                  <!-- ISBN -->
                  <div class="form-group col-12 col-xl-6">
                      <label for="isbn">ISBN</label>
                      <input type="text" id="isbn" name="isbn" class="form-control" placeholder="978-634-04-1924-5">
                  </div>

                  <!-- Publish Date -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="publish_date">Publish Date</label>
                    <div class="input-group">
                      <input type="date" class="form-control" id="publish_date" name="publish_date">
                    </div>
                  </div>

                  <!-- Pages + Dimensi -->
                  <div class="form-group col-12 mb-0">
                    <div class="form-row">
                      <div class="form-group col-6">
                        <label for="pages">Pages</label>
                        <input type="number" id="pages" name="pages" class="form-control">
                      </div>
                      <div class="form-group col-6">
                        <label for="width">Width (cm)</label>
                        <input type="number" step="0.01" id="width" name="width" class="form-control">
                      </div>
                      <div class="form-group col-6">
                        <label for="length">Length (cm)</label>
                        <input type="number" step="0.01" id="length" name="length" class="form-control">
                      </div>
                      <div class="form-group col-6">
                        <label for="thickness">Thickness (cm)</label>
                        <input type="number" step="0.01" id="thickness" name="thickness" class="form-control">
                      </div>
                    </div>
                  </div>

                  <!-- Synopsis -->
                  <div class="form-group col-12">
                    <label for="Synopsis">Synopsis</label>
                    <textarea class="form-control py-1" id="Synopsis" name="Synopsis" rows="5"></textarea>
                  </div>

                  <!-- Writer dengan Sortable -->
                  <div class="form-group col-12">
                    <label for="writter">Writer <small class="text-muted">(Drag to reorder)</small></label>
                    <div class="form-row">
                      <div class="col-10">
                        <!-- Hidden select untuk data source -->
                        <select class="form-control select2-multi" id="writter-select" multiple>
                            <?php $__currentLoopData = $writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($writer->writer_id); ?>"><?php echo e($writer->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                        <!-- Container untuk sortable items -->
                        <div id="selected-writers" class="mt-2" style="min-height: 50px;">
                          <!-- Writer items akan ditambahkan di sini -->
                        </div>
                      </div>
                      <div class="col-2">
                        <button type="button" class="btn btn-outline-primary small" data-toggle="modal" data-target="#addWriterModal" data-whatever="@mdo">+ Writer</button>
                      </div>
                    </div>
                  </div>

                  <!-- Price -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="print_price">Print Price</label>
                    <input type="number" id="print_price" name="print_price" class="form-control" placeholder="50000">
                  </div>
                  <div class="form-group col-12 col-xl-6">
                    <label for="ebook_price">E Book Price</label>
                    <input type="number" id="ebook_price" name="ebook_price" class="form-control" placeholder="20000">
                  </div>
                  
                   <!-- Category -->
                  <div class="form-group col-12 col-xl-6">
                    <label for="category">Category</label>
                    <select class="form-control select2-multi" name="category[]" id="category" multiple required>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->category_id); ?>"><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>

                  <!-- Ebook Path -->
                  <div class="form-group col-12 col-12 col-xl-6">
                      <label for="ebook_path">E Book Path</label>
                      <input type="text" id="ebook_path" name="ebook_path" class="form-control" placeholder="https://ritecs.org/">
                  </div>
                  

                  <!-- Buttons -->
                  <div class="col-12 d-flex justify-content-start mt-3">
                      <button type="submit" class="btn btn-primary mr-2">Add Book</button>
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

<!-- Modal Add Writer -->
<div class="modal fade" id="addWriterModal" tabindex="-1" role="dialog" aria-labelledby="addWriterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addWriterModalLabel">Add New Writer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="writerFormModal" action="<?php echo e(route('admin.writers.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div id="writer-fields-modal">
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
                <div class="col-12 col-md-2 px-0 py-2 p-md-0">
                  <button type="button" class="btn btn-outline-primary w-100" onclick="addFieldModal(event)">+1 item</button>
                </div>
              </div>
            </div>
          </div>
          <p class="text-muted">Menambahkan data <Strong>Writter</Strong> akan memuat ulang halaman</p>

          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
  .writer-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    margin-bottom: 8px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    cursor: move;
    transition: all 0.2s;
  }
  
  .writer-item:hover {
    background: #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .writer-item.dragging {
    opacity: 0.5;
    transform: rotate(2deg);
  }
  
  .writer-item .drag-handle {
    margin-right: 10px;
    color: #6c757d;
    cursor: grab;
  }
  
  .writer-item .drag-handle:active {
    cursor: grabbing;
  }
  
  .writer-item .writer-name {
    flex: 1;
    font-weight: 500;
  }
  
  .writer-item .remove-writer {
    color: #dc3545;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
    padding: 0 5px;
  }
  
  .writer-item .remove-writer:hover {
    color: #c82333;
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<script>
  // Fungsi untuk tambah field baru di modal
  function addFieldModal(e) {
    e.preventDefault();
    let div = document.createElement('div');
    div.classList.add('form-group');
    div.innerHTML = `
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
        <div class="col-12 col-md-2 px-0 py-2 p-md-0">
          <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.form-group').remove()">Delete</button>
        </div>
      </div>
    `;
    document.getElementById('writer-fields-modal').appendChild(div);
  }

  // Writer Sortable Management
  document.addEventListener('DOMContentLoaded', function() {
    const writerSelect = $('#writter-select');
    const selectedWritersContainer = document.getElementById('selected-writers');
    let selectedWriters = [];

    // Initialize Select2
    writerSelect.select2({
      placeholder: 'Select writers...',
      allowClear: true
    });

    // Handle writer selection - LANGSUNG TAMBAH KE AKHIR ARRAY
    writerSelect.on('select2:select', function(e) {
      const writerId = e.params.data.id;
      const writerName = e.params.data.text;
      
      // Hapus dulu jika sudah ada (untuk menghindari duplikat)
      selectedWriters = selectedWriters.filter(w => w.id !== writerId);
      
      // Tambahkan ke AKHIR array (ini yang penting!)
      selectedWriters.push({ id: writerId, name: writerName });
      
      renderWriters();
    });

    // Handle writer deselection
    writerSelect.on('select2:unselect', function(e) {
      const writerId = e.params.data.id;
      selectedWriters = selectedWriters.filter(w => w.id !== writerId);
      renderWriters();
    });

    // Render writers list
    function renderWriters() {
      selectedWritersContainer.innerHTML = '';
      
      selectedWriters.forEach((writer, index) => {
        const writerItem = document.createElement('div');
        writerItem.className = 'writer-item';
        writerItem.dataset.writerId = writer.id;
        writerItem.innerHTML = `
          <span class="drag-handle">☰</span>
          <span class="writer-name">${index + 1}. ${writer.name}</span>
          <span class="remove-writer" onclick="removeWriter('${writer.id}')">&times;</span>
          <input type="hidden" name="writter[]" value="${writer.id}">
        `;
        selectedWritersContainer.appendChild(writerItem);
      });

      updateSelectOptions();
    }

    // Update select2 options
    function updateSelectOptions() {
      const selectedIds = selectedWriters.map(w => w.id);
      writerSelect.val(selectedIds).trigger('change');
    }

    // Remove writer function
    window.removeWriter = function(writerId) {
      selectedWriters = selectedWriters.filter(w => w.id !== writerId);
      renderWriters();
    };

    // Initialize Sortable
    new Sortable(selectedWritersContainer, {
      animation: 150,
      handle: '.drag-handle',
      ghostClass: 'dragging',
      onEnd: function(evt) {
        // Update array order based on DOM
        const newOrder = [];
        selectedWritersContainer.querySelectorAll('.writer-item').forEach(item => {
          const writerId = item.dataset.writerId;
          const writer = selectedWriters.find(w => w.id === writerId);
          if (writer) newOrder.push(writer);
        });
        selectedWriters = newOrder;
        renderWriters();
      }
    });
  });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/published-books/add-books.blade.php ENDPATH**/ ?>