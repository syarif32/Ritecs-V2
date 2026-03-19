<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Card</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .page {
            page-break-after: always;
            text-align: center;
        }
        .page:last-child {
            page-break-after: never;
        }
        img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    <?php if($frontImage): ?>
    <div class="page">
        <img src="<?php echo e($frontImage); ?>" alt="Front Card">
    </div>
    <?php endif; ?>

    <?php if($backImage): ?>
    <div class="page">
        <img src="<?php echo e($backImage); ?>" alt="Back Card">
    </div>
    <?php endif; ?>
</body>
</html><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pdf/membership-card.blade.php ENDPATH**/ ?>