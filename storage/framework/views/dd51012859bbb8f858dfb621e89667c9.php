
<div class="card mt-2">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Referensi Ikon</h6>
    </div>
    <div class="card-body">
        <div class="icon-reference-grid">
            <?php $__currentLoopData = config('icons.font_awesome'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="icon-reference-item">
                <i class="<?php echo e($icon['class']); ?> fa-lg"></i>
                <span class="icon-class"><?php echo e($icon['class']); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<style>
    .icon-reference-grid{display:grid;grid-template-columns:repeat(auto-fill, minmax(250px, 1fr));gap:10px;max-height:200px;overflow-y:auto;padding-top:10px;}
    .icon-reference-item{display:flex;align-items:center;gap:15px;padding:8px;background-color:#f8f9fa;border:1px solid #dee2e6;border-radius:5px;}
    .icon-reference-item i{width:20px;text-align:center;color:#0d6efd;}
    .icon-reference-item .icon-class{font-family:monospace;font-size:0.9em;color:#495057;}
</style><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/partials/icon_reference.blade.php ENDPATH**/ ?>