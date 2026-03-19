<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Layanan Buku</h1>
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow mb-4">
        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kelola Judul & Subjudul Halaman</h6></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.author-guideline.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <fieldset class="mb-3 p-3 border rounded">
                    <legend class="w-auto px-2 h6">Bagian Jenis Buku</legend>
                    <div class="form-group">
                        <label for="guideline_bt_title">Judul Utama</label>
                        <input type="text" id="guideline_bt_title" name="guideline_bt_title" class="form-control" value="<?php echo e($book_types_title->value); ?>">
                    </div>
                    <div class="form-group">
                        <label for="guideline_bt_subtitle">Subjudul</label>
                        <input type="text" id="guideline_bt_subtitle" name="guideline_bt_subtitle" class="form-control" value="<?php echo e($book_types_subtitle->value); ?>">
                    </div>
                </fieldset>
                <fieldset class="mb-3 p-3 border rounded">
                    <legend class="w-auto px-2 h6">Bagian Skema Penerbitan</legend>
                     <div class="form-group">
                        <label for="guideline_ps_title">Judul Utama</label>
                        <input type="text" id="guideline_ps_title" name="guideline_ps_title" class="form-control" value="<?php echo e($schemes_title->value); ?>">
                    </div>
                    <div class="form-group">
                        <label for="guideline_ps_subtitle">Subjudul</label>
                        <input type="text" id="guideline_ps_subtitle" name="guideline_ps_subtitle" class="form-control" value="<?php echo e($schemes_subtitle->value); ?>">
                    </div>
                </fieldset>
                 <fieldset class="p-3 border rounded">
                    <legend class="w-auto px-2 h6">Bagian Prosedur Penerbitan</legend>
                     <div class="form-group">
                        <label for="guideline_st_title">Judul Utama</label>
                        <input type="text" id="guideline_st_title" name="guideline_st_title" class="form-control" value="<?php echo e($steps_title->value); ?>">
                    </div>
                    <div class="form-group">
                        <label for="guideline_st_subtitle">Subjudul</label>
                        <input type="text" id="guideline_st_subtitle" name="guideline_st_subtitle" class="form-control" value="<?php echo e($steps_subtitle->value); ?>">
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary mt-3">Simpan Semua Judul</button>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Jenis Buku</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBookTypeModal">Tambah Jenis Buku</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Ikon</th><th>Nama</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $book_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><i class="<?php echo e($item->icon); ?>"></i></td>
                        <td><?php echo e($item->name); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editBookTypeModal"
                                    data-id="<?php echo e($item->id); ?>" data-icon="<?php echo e($item->icon); ?>" data-name="<?php echo e($item->name); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.book-types.destroy', $item)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Skema Penerbitan</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSchemeModal">Tambah Skema</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Ikon</th><th>Judul</th><th>Fitur</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $publishing_schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><i class="<?php echo e($item->icon); ?>"></i></td>
                        <td><?php echo e($item->title); ?></td>
                        <td><?php echo e($item->feature); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSchemeModal"
                                    data-id="<?php echo e($item->id); ?>" data-icon="<?php echo e($item->icon); ?>" data-title="<?php echo e($item->title); ?>"
                                    data-description="<?php echo e($item->description); ?>" data-feature="<?php echo e($item->feature); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.publishing-schemes.destroy', $item)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Prosedur Penerbitan</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addStepModal">Tambah Tahap</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Judul</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                <tbody>
                     <?php $__empty_1 = true; $__currentLoopData = $publishing_steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($item->title); ?></td>
                        <td><?php echo e(Str::limit($item->description, 70)); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editStepModal"
                                    data-id="<?php echo e($item->id); ?>" data-title="<?php echo e($item->title); ?>" data-description="<?php echo e($item->description); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.publishing-steps.destroy', $item)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="addBookTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Buku</h5>
            </div>
            <form action="<?php echo e(route('admin.book-types.store')); ?>" method="POST">
                <div class="modal-body"><?php echo csrf_field(); ?><div class="form-group">
                    <label>Nama</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group">
                        <label>Ikon</label><input type="text" name="icon" class="form-control" required></div><?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

<div class="modal fade" id="editBookTypeModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Edit Jenis Buku</h5></div><form id="editBookTypeForm" method="POST"><div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label for="edit_bt_name">Nama</label><input type="text" id="edit_bt_name" name="name" class="form-control" required></div><div class="form-group"><label for="edit_bt_icon">Ikon</label><input type="text" id="edit_bt_icon" name="icon" class="form-control" required></div><?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div></form></div></div></div>


<div class="modal fade" id="addSchemeModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Tambah Skema</h5></div><form action="<?php echo e(route('admin.publishing-schemes.store')); ?>" method="POST"><div class="modal-body"><?php echo csrf_field(); ?><div class="form-group"><label>Judul</label><input type="text" name="title" class="form-control" required></div><div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control" required></textarea></div><div class="form-group"><label>Fitur Unggulan</label><input type="text" name="feature" class="form-control" required></div><div class="form-group"><label>Ikon</label><input type="text" name="icon" class="form-control" required></div><?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>
<div class="modal fade" id="editSchemeModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Edit Skema</h5></div><form id="editSchemeForm" method="POST"><div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label for="edit_ps_title">Judul</label><input type="text" id="edit_ps_title" name="title" class="form-control" required></div><div class="form-group"><label for="edit_ps_description">Deskripsi</label><textarea id="edit_ps_description" name="description" class="form-control" required></textarea></div><div class="form-group"><label for="edit_ps_feature">Fitur Unggulan</label><input type="text" id="edit_ps_feature" name="feature" class="form-control" required></div><div class="form-group"><label for="edit_ps_icon">Ikon</label><input type="text" id="edit_ps_icon" name="icon" class="form-control" required></div><?php echo $__env->make('backend.partials.icon_reference', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div></form></div></div></div>


<div class="modal fade" id="addStepModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Tambah Tahap</h5></div><form action="<?php echo e(route('admin.publishing-steps.store')); ?>" method="POST"><div class="modal-body"><?php echo csrf_field(); ?><div class="form-group"><label>Judul</label><input type="text" name="title" class="form-control" required></div><div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control" required></textarea></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>
<div class="modal fade" id="editStepModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Edit Tahap</h5></div><form id="editStepForm" method="POST"><div class="modal-body"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label for="edit_st_title">Judul</label><input type="text" id="edit_st_title" name="title" class="form-control" required></div><div class="form-group"><label for="edit_st_description">Deskripsi</label><textarea id="edit_st_description" name="description" class="form-control" required></textarea></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div></form></div></div></div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Modal Edit Book Type
    $('#editBookTypeModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_bt_name').val(button.data('name'));
        $('#edit_bt_icon').val(button.data('icon'));
        var action = '<?php echo e(url("admin/book-types")); ?>/' + button.data('id');
        $('#editBookTypeForm').attr('action', action);
    });

    // Modal Edit Publishing Scheme
    $('#editSchemeModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_ps_title').val(button.data('title'));
        $('#edit_ps_description').val(button.data('description'));
        $('#edit_ps_feature').val(button.data('feature'));
        $('#edit_ps_icon').val(button.data('icon'));
        var action = '<?php echo e(url("admin/publishing-schemes")); ?>/' + button.data('id');
        $('#editSchemeForm').attr('action', action);
    });

    // Modal Edit Publishing Step
    $('#editStepModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#edit_st_title').val(button.data('title'));
        $('#edit_st_description').val(button.data('description'));
        var action = '<?php echo e(url("admin/publishing-steps")); ?>/' + button.data('id');
        $('#editStepForm').attr('action', action);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\author_guideline\index.blade.php ENDPATH**/ ?>