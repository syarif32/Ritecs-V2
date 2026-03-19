<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Halaman Visi & Misi</h1>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <h5 class="alert-heading">Terjadi Kesalahan!</h5>
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

    
    <form action="<?php echo e(route('admin.page.vision-mission.update')); ?>" method="POST"  id="vision-mission-form">
        <?php echo csrf_field(); ?>
        
        <div class="card shadow mb-4">
            <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Konten Visi</h6></div>
            <div class="card-body">
                <input type="hidden" name="vision_text" id="vision_text_input">
                <div id="editor-vision" style="min-height:150px;">
                    <?php echo $vision->value; ?>

                </div>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Konten Misi</h6></div>
            <div class="card-body">
                <input type="hidden" name="mission_text" id="mission_text_input">
                <div id="editor-mission" style="min-height:200px;">
                    <?php echo $mission->value; ?>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Semua Perubahan</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // SCRIPT UNTUK TEXT EDITOR
    const visionEditor = document.getElementById('editor-vision');
    if (visionEditor) {
        const quillVision = new Quill('#editor-vision', { theme: 'snow' });
        const quillMission = new Quill('#editor-mission', { theme: 'snow' });
        
        const form = document.getElementById('vision-mission-form');
        form.addEventListener('submit', function(e) {
            document.getElementById('vision_text_input').value = quillVision.root.innerHTML;
            document.getElementById('mission_text_input').value = quillMission.root.innerHTML;
        });
    }
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\vision_mission\index.blade.php ENDPATH**/ ?>