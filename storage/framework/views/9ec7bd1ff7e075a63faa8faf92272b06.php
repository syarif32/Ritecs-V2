<!DOCTYPE html>
<html>
<head>
    <title>Balasan dari Ritecs</title>
</head>
<body>
    <h3>Halo, <?php echo e($name); ?></h3>
    
    <p>Terima kasih telah menghubungi Ritecs. Berikut adalah tanggapan kami atas pesan Anda:</p>
    
    <div style="border-left: 4px solid #4e73df; padding-left: 15px; margin: 20px 0; background-color: #f8f9fc; padding: 10px;">
        <p><strong>Balasan Admin:</strong></p>
        <p><?php echo e($reply_message); ?></p>
    </div>

    <hr>
    <p><small>Pesan asli Anda:</small></p>
    <p><small><em>"<?php echo e($original_message); ?>"</em></small></p>
    
    <br>
    <p>Salam Hangat,<br>Tim Ritecs</p>
</body>
</html><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/pages/emails/reply.blade.php ENDPATH**/ ?>