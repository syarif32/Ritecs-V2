<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Membership</h1>
    
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow mb-4">
        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kelola Harga Membership</h6></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.membership.updatePrice')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">Harga (Contoh: 150K)</label>
                        <input type="text" id="price" name="price" class="form-control" value="<?php echo e($price->value); ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price_description">Deskripsi Singkat Harga</label>
                        <input type="text" id="price_description" name="price_description" class="form-control" value="<?php echo e($price_description->value); ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Harga</button>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Keuntungan Anggota</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBenefitModal">
                Tambah Keuntungan
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Ikon</th><th>Judul</th><th>Deskripsi</th><th>Unggulan</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><i class="<?php echo e($benefit->icon); ?>"></i></td>
                        <td><?php echo e($benefit->title); ?></td>
                        <td><?php echo e(Str::limit($benefit->description, 50)); ?></td>
                        <td><?php echo e($benefit->is_featured ? 'Ya' : 'Tidak'); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm edit-benefit-btn" 
                                    data-toggle="modal" 
                                    data-target="#editBenefitModal"
                                    data-id="<?php echo e($benefit->id); ?>"
                                    data-icon="<?php echo e($benefit->icon); ?>"
                                    data-title="<?php echo e($benefit->title); ?>"
                                    data-description="<?php echo e($benefit->description); ?>"
                                    data-is_featured="<?php echo e($benefit->is_featured); ?>">
                                Edit
                            </button>
                            <form action="<?php echo e(route('admin.benefits.destroy', $benefit)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center">Belum ada data keuntungan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Pertanyaan Umum (FAQ)</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFaqModal">
                Tambah FAQ
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Pertanyaan</th><th>Jawaban</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                            <form action="<?php echo e(route('admin.faqs.destroy', $faq)); ?>" method="POST" class="d-inline">
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

<div class="modal fade" id="addBenefitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Keuntungan Baru</h5></div>
            <form action="<?php echo e(route('admin.benefits.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Keuntungan</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="icon">Ikon</label>
                        <input type="text" name="icon" class="form-control" required>
                        <small>Pilih dari referensi di bawah.</small>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="is_featured_add">
                        <label class="form-check-label" for="is_featured_add">Jadikan Keuntungan Unggulan (Tampil di Kartu Harga)</label>
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

<div class="modal fade" id="editBenefitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Keuntungan</h5></div>
            <form id="editBenefitForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">Judul Keuntungan</label>
                        <input type="text" id="edit_title" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Deskripsi</label>
                        <textarea id="edit_description" name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_icon">Ikon</label>
                        <input type="text" id="edit_icon" name="icon" class="form-control" required>
                        <small>Pilih dari referensi di bawah.</small>
                    </div>
                    <?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="edit_is_featured">
                        <label class="form-check-label" for="edit_is_featured">Jadikan Keuntungan Unggulan (Tampil di Kartu Harga)</label>
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
            <form action="<?php echo e(route('admin.faqs.store')); ?>" method="POST">
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
   // benefit
    $('#editBenefitModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var icon = button.data('icon');
        var title = button.data('title');
        var description = button.data('description');
        var isFeatured = button.data('is_featured');
        
        var modal = $(this);
        var form = modal.find('#editBenefitForm');
        
        var actionUrl = '<?php echo e(url("admin/benefits")); ?>/' + id;
        form.attr('action', actionUrl);
        
        modal.find('#edit_icon').val(icon);
        modal.find('#edit_title').val(title);
        modal.find('#edit_description').val(description);
        modal.find('#edit_is_featured').prop('checked', isFeatured == 1);
    });

    // faq
    $('#editFaqModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var question = button.data('question');
        var answer = button.data('answer');
        
        var modal = $(this);
        var form = modal.find('#editFaqForm');
        
        var actionUrl = '<?php echo e(url("admin/faqs")); ?>/' + id;
        form.attr('action', actionUrl);
        
        modal.find('#edit_question').val(question);
        modal.find('#edit_answer').val(answer);
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\membership\index.blade.php ENDPATH**/ ?>