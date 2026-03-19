
    <?php echo $__env->make('backend.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('backend.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('backend.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <main role="main" class="main-content">
    <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('backend.partials.endbody', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/layouts/main.blade.php ENDPATH**/ ?>