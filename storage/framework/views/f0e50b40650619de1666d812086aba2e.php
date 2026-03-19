<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Ritecs</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6;">

    <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <tr>
            <td style="padding: 30px 40px 20px 40px; text-align: center; border-bottom: 1px solid #e9ecef;">
                <img src="https://ritecs.org/sites/assets/img/logo/logo-text.webp" alt="Ritecs Logo" width="150" style="max-width: 150px; background: transparent;">
            </td>
        </tr>

        <tr>
            <td style="padding: 40px;">
                <h1 class="fallback-font" style="font-size: 24px; font-weight: 700; color: #222222; margin-top: 0; margin-bottom: 20px;">
                    Permintaan Reset Password
                </h1>
                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                    Halo! Kami menerima permintaan untuk mereset password akun Ritecs Anda. Klik tombol di bawah ini untuk membuat password baru:
                </p>
                
                <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <a href="<?php echo e($url); ?>" target="_blank" style="background-color: #0d6efd; color: #ffffff; padding: 14px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3);">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>

                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555; margin-top: 30px;">
                    Link ini hanya berlaku selama 60 menit.
                </p>
                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555;">
                    Jika Anda tidak merasa meminta reset password, abaikan saja email ini. Akun Anda tetap aman.
                </p>
                
                <p style="margin-top: 30px; font-size: 12px; color: #999;">
                    Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:<br>
                    <a href="<?php echo e($url); ?>" style="color: #0d6efd; word-break: break-all;"><?php echo e($url); ?></a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 40px; text-align: center; background-color: #fafafa; border-top: 1px solid #e9ecef; border-radius: 0 0 8px 8px;">
                <p class="fallback-font" style="font-size: 12px; color: #888888; margin: 0;">
                    &copy; <?php echo e(date('Y')); ?> Ritecs. All rights reserved.
                </p>
                <p class="fallback-font" style="font-size: 12px; color: #888888; margin: 5px 0 0 0;">
                    Semarang, Jawa Tengah, Indonesia
                </p>
            </td>
        </tr>
    </table>
</body>
</html><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\pages\emails\reset_password.blade.php ENDPATH**/ ?>