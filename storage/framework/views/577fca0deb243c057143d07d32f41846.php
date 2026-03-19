<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="page-title">Kelola Halaman Home</h2>
            <p class="text-muted">Atur konten slide carousel, gambar ilustrasi, dan pertanyaan umum (FAQ).</p>
        </div>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fe fe-check-circle mr-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>


    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fe fe-image mr-2"></i>Slide Carousel</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCarouselModal">
                        <i class="fe fe-plus mr-1"></i> Tambah Slide
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="15%">Preview</th>
                                    <th>Konten Slide</th>
                                    <th>Tombol Aksi</th>
                                    <th width="15%" class="text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="align-middle text-center">
                                        <img src="<?php echo e(asset('storage/' . $carousel->image_path)); ?>" alt="carousel" class="rounded shadow-sm" style="width: 120px; height: 70px; object-fit: cover;">
                                    </td>
                                    <td class="align-middle">
                                        <small class="text-muted text-uppercase"><?php echo e($carousel->pre_title); ?></small>
                                        <h6 class="font-weight-bold text-dark mb-1"><?php echo e($carousel->title); ?></h6>
                                        <p class="text-muted small mb-0"><?php echo e(Str::limit($carousel->description, 60)); ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <?php if($carousel->button1_text): ?>
                                            <span class="badge badge-light border"><?php echo e($carousel->button1_text); ?></span>
                                        <?php endif; ?>
                                        <?php if($carousel->button2_text): ?>
                                            <span class="badge badge-light border"><?php echo e($carousel->button2_text); ?></span>
                                        <?php endif; ?>
                                        <?php if(!$carousel->button1_text && !$carousel->button2_text): ?>
                                            <span class="text-muted small font-italic">- Tidak ada tombol -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-carousel-btn" 
                                                data-toggle="modal" data-target="#editCarouselModal"
                                                data-id="<?php echo e($carousel->id); ?>"
                                                data-pre_title="<?php echo e($carousel->pre_title); ?>"
                                                data-title="<?php echo e($carousel->title); ?>"
                                                data-subtitle="<?php echo e($carousel->subtitle); ?>"
                                                data-description="<?php echo e($carousel->description); ?>"
                                                data-image_path="<?php echo e(asset('storage/' . $carousel->image_path)); ?>"
                                                data-button1_text="<?php echo e($carousel->button1_text); ?>"
                                                data-button1_url="<?php echo e($carousel->button1_url); ?>"
                                                data-button2_text="<?php echo e($carousel->button2_text); ?>"
                                                data-button2_url="<?php echo e($carousel->button2_url); ?>"
                                                title="Edit Slide">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.carousels.destroy', $carousel)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus slide ini?')" title="Hapus Slide">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/surr-waiting.svg" width="100" class="mb-3 opacity-50">
                                        <p class="text-muted">Belum ada slide carousel yang ditambahkan.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        
        <div class="col-md-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fe fe-help-circle mr-2"></i>Daftar FAQ</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFaqModal">
                        <i class="fe fe-plus mr-1"></i> Tambah FAQ
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $home_faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="align-top"><?php echo e($loop->iteration); ?></td>
                                    <td class="align-top font-weight-bold"><?php echo e(Str::limit($faq->question, 40)); ?></td>
                                    <td class="align-top text-muted small"><?php echo e(Str::limit($faq->answer, 80)); ?></td>
                                    <td class="align-top text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-faq-btn" 
                                                data-toggle="modal" data-target="#editFaqModal"
                                                data-id="<?php echo e($faq->id); ?>"
                                                data-question="<?php echo e($faq->question); ?>"
                                                data-answer="<?php echo e($faq->answer); ?>">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.home-faqs.destroy', $faq)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pertanyaan ini?')">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data FAQ.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ilustrasi FAQ</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase mb-2">Gambar Saat Ini</label>
                        <div class="bg-light p-2 rounded border mx-auto" style="width: fit-content;">
                            <img src="<?php echo e(asset('storage/' . $faq_image)); ?>" alt="FAQ Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                    
                    <hr>

                    <form action="<?php echo e(route('admin.page.home.updateFaqImage')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group text-left">
                            <label for="faq_image" class="small font-weight-bold">Ganti Gambar</label>
                            <div class="custom-file">
                                <input type="file" name="faq_image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Pilih file...</label>
                            </div>
                            <small class="text-muted mt-1 d-block">Format: JPG, PNG. Max: 2MB.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fe fe-save mr-1"></i> Simpan Gambar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div> 
</div>




<div class="modal fade" id="addCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Slide Carousel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('admin.carousels.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pre-Title <small class="text-muted">(Teks Kecil Atas)</small></label>
                                <input type="text" name="pre_title" class="form-control" placeholder="Contoh: Welcome to" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title <small class="text-muted">(Teks Utama)</small></label>
                                <input type="text" name="title" class="form-control" placeholder="Contoh: Ritecs Platform" required>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label>Subtitle / Legal Text <small class="text-muted">(Opsional)</small></label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="Contoh: Terdaftar pada Kementrian Hukum..."></textarea>
                        <small class="text-muted">Tekan Enter untuk membuat baris baru.</small>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat slide..." required></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Gambar Background</label>
                        <div class="custom-file">
                            <input type="file" name="image_path" class="custom-file-input" required id="addCarouselImg">
                            <label class="custom-file-label" for="addCarouselImg">Pilih gambar...</label>
                        </div>
                    </div>

                    
                    <div class="p-3 bg-light rounded mt-3">
                        <h6 class="text-primary mb-3"><i class="fe fe-mouse-pointer mr-1"></i>Konfigurasi Tombol (Opsional)</h6>
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <small class="d-block text-uppercase text-muted font-weight-bold mb-2">Tombol 1 (Primary)</small>
                                <div class="form-group"><input type="text" name="button1_text" class="form-control form-control-sm" placeholder="Label Tombol"></div>
                                <div class="form-group mb-0"><input type="text" name="button1_url" class="form-control form-control-sm" placeholder="URL / Link"></div>
                            </div>
                            <div class="col-md-6">
                                <small class="d-block text-uppercase text-muted font-weight-bold mb-2">Tombol 2 (Secondary)</small>
                                <div class="form-group"><input type="text" name="button2_text" class="form-control form-control-sm" placeholder="Label Tombol"></div>
                                <div class="form-group mb-0"><input type="text" name="button2_url" class="form-control form-control-sm" placeholder="URL / Link"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Slide Carousel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCarouselForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>Pre-Title</label><input type="text" id="edit_pre_title" name="pre_title" class="form-control" required></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Title</label><input type="text" id="edit_title" name="title" class="form-control" required></div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label>Subtitle / Legal Text</label>
                        <textarea id="edit_subtitle" name="subtitle" class="form-control" rows="2"></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label class="small text-muted d-block">Preview Saat Ini</label>
                            <img id="edit_image_preview" src="" alt="preview" class="img-fluid rounded border shadow-sm">
                        </div>
                        <div class="col-md-9">
                            <label>Ganti Gambar <small class="text-muted">(Biarkan kosong jika tetap)</small></label>
                            <div class="custom-file">
                                <input type="file" name="image_path" class="custom-file-input" id="editCarouselImg">
                                <label class="custom-file-label" for="editCarouselImg">Pilih file baru...</label>
                            </div>
                        </div>
                    </div>

                    
                    <div class="p-3 bg-light rounded mt-3">
                        <h6 class="text-primary mb-3">Konfigurasi Tombol</h6>
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <small class="d-block text-uppercase text-muted font-weight-bold mb-2">Tombol 1</small>
                                <div class="form-group"><input type="text" id="edit_button1_text" name="button1_text" class="form-control form-control-sm" placeholder="Label"></div>
                                <div class="form-group mb-0"><input type="text" id="edit_button1_url" name="button1_url" class="form-control form-control-sm" placeholder="URL"></div>
                            </div>
                            <div class="col-md-6">
                                <small class="d-block text-uppercase text-muted font-weight-bold mb-2">Tombol 2</small>
                                <div class="form-group"><input type="text" id="edit_button2_text" name="button2_text" class="form-control form-control-sm" placeholder="Label"></div>
                                <div class="form-group mb-0"><input type="text" id="edit_button2_url" name="button2_url" class="form-control form-control-sm" placeholder="URL"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="addFaqModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah FAQ Baru</h5></div>
            <form action="<?php echo e(route('admin.home-faqs.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="question">Pertanyaan</label>
                        <input type="text" name="question" class="form-control" placeholder="Tulis pertanyaan..." required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Jawaban</label>
                        <textarea name="answer" class="form-control" rows="4" placeholder="Tulis jawaban..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit FAQ</h5></div>
            <form id="editFaqForm" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_question">Pertanyaan</label>
                        <input type="text" id="edit_question" name="question" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_answer">Jawaban</label>
                        <textarea id="edit_answer" name="answer" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<script>
$(document).ready(function() {
 
    // 1. MODAL CAROUSEL (Edit Logic)
  
    $('#editCarouselModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang diklik
        var id = button.data('id');
        
        var form = $('#editCarouselForm');
        var actionUrl = '<?php echo e(url("admin/carousels")); ?>/' + id;
        form.attr('action', actionUrl);

      
        form.find('#edit_pre_title').val(button.data('pre_title'));
        form.find('#edit_title').val(button.data('title'));
        
       
        form.find('#edit_subtitle').val(button.data('subtitle')); 
      

        form.find('#edit_description').val(button.data('description'));
        form.find('#edit_image_preview').attr('src', button.data('image_path'));
        form.find('#edit_button1_text').val(button.data('button1_text'));
        form.find('#edit_button1_url').val(button.data('button1_url'));
        form.find('#edit_button2_text').val(button.data('button2_text'));
        form.find('#edit_button2_url').val(button.data('button2_url'));
    });

    
    // 2. MODAL FAQ (Edit Logic)
  
    $('#editFaqModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var question = button.data('question');
        var answer = button.data('answer');
        
        var modal = $(this);
        var form = modal.find('#editFaqForm');
        
        var actionUrl = '<?php echo e(url("admin/home-faqs")); ?>/' + id;
        form.attr('action', actionUrl);
        
        modal.find('#edit_question').val(question);
        modal.find('#edit_answer').val(answer);
        
        
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/home/index.blade.php ENDPATH**/ ?>