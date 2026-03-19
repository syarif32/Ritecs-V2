

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Tim</h1>
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>


    <div class="card shadow mb-4">
        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kelola Judul & Deskripsi Halaman Tim</h6></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.page.team.updateSettings')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="team_pre_title">Pre-Judul (teks kecil warna primer)</label>
                    <input type="text" id="team_pre_title" name="team_pre_title" class="form-control" value="<?php echo e($settings['team_pre_title'] ?? 'Our Team'); ?>">
                </div>
                <div class="form-group">
                    <label for="team_title">Judul Utama</label>
                    <input type="text" id="team_title" name="team_title" class="form-control" value="<?php echo e($settings['team_title'] ?? 'Meet Our Expert Team Members'); ?>">
                </div>
                <div class="form-group">
                    <label for="team_description">Deskripsi</label>
                    <textarea id="team_description" name="team_description" class="form-control" rows="3"><?php echo e($settings['team_description'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Anggota Tim</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTeamModal">Tambah Anggota</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><img src="<?php echo e(asset('storage/' . $item->img_path)); ?>" alt="<?php echo e($item->name); ?>" width="80"></td>
                        <td><?php echo e($item->name); ?></td>
                        <td><?php echo e($item->position); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTeamModal"
                                data-id="<?php echo e($item->team_id); ?>"
                                data-name="<?php echo e($item->name); ?>"
                                data-position="<?php echo e($item->position); ?>"
                                data-facebook_url="<?php echo e($item->facebook_url); ?>"
                                data-twitter_url="<?php echo e($item->twitter_url); ?>"
                                data-linkedin_url="<?php echo e($item->linkedin_url); ?>"
                                data-instagram_url="<?php echo e($item->instagram_url); ?>"
                                data-img_path="<?php echo e(asset('storage/' . $item->img_path)); ?>"
>
                                Edit
                            </button>
                            <form action="<?php echo e(route('admin.page.team.destroy', $item)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center">Belum ada anggota tim.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota Tim</h5>
            </div>
            <form action="<?php echo e(route('admin.page.team.store')); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group"><label>Posisi</label><input type="text" name="position" class="form-control" required></div>
                    <div class="form-group"><label>Foto (Max: 2MB)</label><input type="file" name="img_path" class="form-control" required></div>
                    <hr>
                    <h6 class="text-muted">Link Sosial Media (Opsional)</h6>
                    <div class="form-group"><label>URL Facebook</label><input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/username"></div>
                    <div class="form-group"><label>URL Twitter</label><input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/username"></div>
                    <div class="form-group"><label>URL LinkedIn</label><input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username"></div>
                    <div class="form-group"><label>URL Instagram</label><input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/username"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Anggota Tim</h5>
            </div>
            <form id="editTeamForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group"><label for="edit_name">Nama Lengkap</label><input type="text" id="edit_name" name="name" class="form-control" required></div>
                    <div class="form-group"><label for="edit_position">Posisi</label><input type="text" id="edit_position" name="position" class="form-control" required></div>
                    <div class="form-group">
                        <label>Foto (Max: 2MB)</label><br>
                        <img id="current_image" src="" width="100" class="mb-2" alt="Current Image">
                        <input type="file" name="img_path" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                     <hr>
                    <h6 class="text-muted">Link Sosial Media (Opsional)</h6>
                    <div class="form-group"><label for="edit_facebook_url">URL Facebook</label><input type="url" id="edit_facebook_url" name="facebook_url" class="form-control"></div>
                    <div class="form-group"><label for="edit_twitter_url">URL Twitter</label><input type="url" id="edit_twitter_url" name="twitter_url" class="form-control"></div>
                    <div class="form-group"><label for="edit_linkedin_url">URL LinkedIn</label><input type="url" id="edit_linkedin_url" name="linkedin_url" class="form-control"></div>
                    <div class="form-group"><label for="edit_instagram_url">URL Instagram</label><input type="url" id="edit_instagram_url" name="instagram_url" class="form-control"></div>
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
    $('#editTeamModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

      
        var id = button.data('id');
        var name = button.data('name');
        var position = button.data('position');
        var facebook_url = button.data('facebook_url');
        var twitter_url = button.data('twitter_url');
        var linkedin_url = button.data('linkedin_url');
        var instagram_url = button.data('instagram_url');
        var img_path = button.data('img_path');

        
        modal.find('#edit_name').val(name);
        modal.find('#edit_position').val(position);
        modal.find('#edit_facebook_url').val(facebook_url);
        modal.find('#edit_twitter_url').val(twitter_url);
        modal.find('#edit_linkedin_url').val(linkedin_url);
        modal.find('#edit_instagram_url').val(instagram_url);
        modal.find('#current_image').attr('src', img_path);

       
        var actionUrl = '<?php echo e(url("admin/page/team/update")); ?>/' + id;
        modal.find('#editTeamForm').attr('action', actionUrl);
    });
});
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\team\index.blade.php ENDPATH**/ ?>