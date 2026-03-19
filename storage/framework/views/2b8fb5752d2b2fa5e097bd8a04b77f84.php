<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman Visi & Misi</h1>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading font-weight-bold"><i class="fas fa-exclamation-triangle mr-1"></i> Terjadi Kesalahan!</h6>
            <ul class="mb-0 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.page.vision-mission.update')); ?>" method="POST" id="vision-mission-form">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold" style="color:white;">
                            <i class="fas fa-eye mr-2"></i>Konten Visi
                        </h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="alert alert-light border small text-muted mb-2">
                            <i class="fas fa-info-circle mr-1"></i> Tuliskan visi jangka panjang organisasi di sini.
                        </div>
                        
                        <input type="hidden" name="vision_text" id="vision_text_input">
                        
                        
                        <div class="editor-wrapper flex-grow-1">
                            <div id="editor-vision" style="min-height: 250px; background: white;">
                                <?php echo $vision->value; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-bullseye mr-2"></i>Konten Misi
                        </h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="alert alert-light border small text-muted mb-2">
                            <i class="fas fa-info-circle mr-1"></i> Gunakan format list (poin-poin) agar misi mudah dibaca.
                        </div>
                        
                        <input type="hidden" name="mission_text" id="mission_text_input">
                        
                        
                        <div class="editor-wrapper flex-grow-1">
                            <div id="editor-mission" style="min-height: 250px; background: white;">
                                <?php echo $mission->value; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <span class="text-muted small">Pastikan konten sudah benar sebelum disimpan.</span>
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-save mr-2"></i> Simpan Semua Perubahan
                </button>
            </div>
        </div>

    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

<style>
    .ql-container {
        font-size: 1rem;
        border-bottom-left-radius: 0.35rem;
        border-bottom-right-radius: 0.35rem;
    }
    .ql-toolbar {
        border-top-left-radius: 0.35rem;
        border-top-right-radius: 0.35rem;
        background-color: #f8f9fc;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Konfigurasi Toolbar Standar
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ];

        // 1. Inisialisasi Editor Visi
        var visionEditor = document.getElementById('editor-vision');
        var quillVision = null;
        if (visionEditor) {
            quillVision = new Quill('#editor-vision', {
                theme: 'snow',
                modules: { toolbar: toolbarOptions },
                placeholder: 'Tulis visi di sini...'
            });
        }

        // 2. Inisialisasi Editor Misi
        var missionEditor = document.getElementById('editor-mission');
        var quillMission = null;
        if (missionEditor) {
            quillMission = new Quill('#editor-mission', {
                theme: 'snow',
                modules: { toolbar: toolbarOptions },
                placeholder: 'Tulis poin-poin misi di sini...'
            });
        }

        // 3. Logic Submit Form
        var form = document.getElementById('vision-mission-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Pindahkan HTML dari Editor ke Input Hidden sebelum submit
                if (quillVision) {
                    document.getElementById('vision_text_input').value = quillVision.root.innerHTML;
                }
                if (quillMission) {
                    document.getElementById('mission_text_input').value = quillMission.root.innerHTML;
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/vision_mission/index.blade.php ENDPATH**/ ?>