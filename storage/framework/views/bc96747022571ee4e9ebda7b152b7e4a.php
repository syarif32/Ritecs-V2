<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Home</h1>
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger"><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Carousel</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCarouselModal">Tambah Slide</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Gambar</th><th>Judul</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><img src="<?php echo e(asset('storage/' . $carousel->image_path)); ?>" alt="carousel" width="100"></td>
                        <td><?php echo e($carousel->title); ?></td>
                        <td><?php echo e(Str::limit($carousel->description, 50)); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm edit-carousel-btn" data-toggle="modal" data-target="#editCarouselModal"
                                    data-id="<?php echo e($carousel->id); ?>"
                                    data-pre_title="<?php echo e($carousel->pre_title); ?>"
                                    data-title="<?php echo e($carousel->title); ?>"
                                    data-description="<?php echo e($carousel->description); ?>"
                                    data-image_path="<?php echo e(asset('storage/' . $carousel->image_path)); ?>"
                                    data-button1_text="<?php echo e($carousel->button1_text); ?>"
                                    data-button1_url="<?php echo e($carousel->button1_url); ?>"
                                    data-button2_text="<?php echo e($carousel->button2_text); ?>"
                                    data-button2_url="<?php echo e($carousel->button2_url); ?>">
                                Edit
                            </button>
                            <form action="<?php echo e(route('admin.carousels.destroy', $carousel)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center">Belum ada slide carousel.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kelola Gambar di Samping FAQ</h6></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.home.updateFaqImage')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="faq_image">Upload Gambar Baru</label>
                    <input type="file" name="faq_image" class="form-control">
                    <small>Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>
                <div class="form-group">
                    <label>Gambar Saat Ini:</label><br>
                    <img src="<?php echo e(asset('storage/' . $faq_image)); ?>" alt="FAQ Image" style="max-height: 150px; border-radius: 8px;">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Gambar</button>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Pertanyaan Umum (FAQ) Halaman Home</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFaqModal">Tambah FAQ</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Pertanyaan</th><th>Jawaban</th><th width="15%">Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $home_faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(Str::limit($faq->question, 40)); ?></td>
                        <td><?php echo e(Str::limit($faq->answer, 60)); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm edit-faq-btn" 
                                    data-toggle="modal" 
                                    data-target="#editFaqModal"
                                    data-id="<?php echo e($faq->id); ?>"
                                    data-question="<?php echo e($faq->question); ?>"
                                    data-answer="<?php echo e($faq->answer); ?>">
                                Edit
                            </button>
                            <form action="<?php echo e(route('admin.home-faqs.destroy', $faq)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center">Belum ada data FAQ.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Slide Carousel</h5>
            </div>
            <form action="<?php echo e(route('admin.carousels.store')); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Pre-Title (Teks Kecil Atas)</label>
                        <input type="text" name="pre_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Title (Teks Besar)</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="image_path" class="form-control" required>
                    </div>
                    <hr>
                    <p>Tombol (Opsional)</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>Teks Tombol 1</label><input type="text" name="button1_text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>URL Tombol 1</label><input type="text" name="button1_url" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Teks Tombol 2</label><input type="text" name="button2_text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>URL Tombol 2</label><input type="text" name="button2_url" class="form-control"></div>
                        </div>
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

<div class="modal fade" id="editCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Slide Carousel</h5>
            </div>
            <form id="editCarouselForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group"><label>Pre-Title</label><input type="text" id="edit_pre_title" name="pre_title" class="form-control" required></div>
                    <div class="form-group"><label>Title</label><input type="text" id="edit_title" name="title" class="form-control" required></div>
                    <div class="form-group"><label>Deskripsi</label><textarea id="edit_description" name="description" class="form-control" required></textarea></div>
                    <div class="form-group"><label>Gambar Baru (Kosongkan jika tidak ganti)</label><input type="file" name="image_path" class="form-control"></div>
                    <div class="form-group"><label>Gambar Saat Ini:</label><br><img id="edit_image_preview" src="" alt="preview" width="150" class="rounded"></div>
                    <hr>
                    <p>Tombol (Opsional)</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>Teks Tombol 1</label><input type="text" id="edit_button1_text" name="button1_text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>URL Tombol 1</label><input type="text" id="edit_button1_url" name="button1_url" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Teks Tombol 2</label><input type="text" id="edit_button2_text" name="button2_text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>URL Tombol 2</label><input type="text" id="edit_button2_url" name="button2_url" class="form-control"></div>
                        </div>
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

<div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah FAQ Baru</h5></div>
            <form action="<?php echo e(route('admin.home-faqs.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="question">Pertanyaan</label>
                        <input type="text" name="question" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Jawaban</label>
                        <textarea name="answer" class="form-control" required></textarea>
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

<div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit FAQ</h5></div>
            <form id="editFaqForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_question">Pertanyaan</label>
                        <input type="text" id="edit_question" name="question" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_answer">Jawaban</label>
                        <textarea id="edit_answer" name="answer" class="form-control" required></textarea>
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
$(document).ready(function() {
    // MODAL CAROUSEL
    $('#editCarouselModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        
        var form = $('#editCarouselForm');
        var actionUrl = '<?php echo e(url("admin/carousels")); ?>/' + id;
        form.attr('action', actionUrl);

        form.find('#edit_pre_title').val(button.data('pre_title'));
        form.find('#edit_title').val(button.data('title'));
        form.find('#edit_description').val(button.data('description'));
        form.find('#edit_image_preview').attr('src', button.data('image_path'));
        form.find('#edit_button1_text').val(button.data('button1_text'));
        form.find('#edit_button1_url').val(button.data('button1_url'));
        form.find('#edit_button2_text').val(button.data('button2_text'));
        form.find('#edit_button2_url').val(button.data('button2_url'));
    });

    //  MODAL FAQ
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
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\home\index.blade.php ENDPATH**/ ?>