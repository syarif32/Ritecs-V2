<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Anda</title>
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
                    Verifikasi Alamat Email Anda
                </h1>
                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                    Terima kasih telah mendaftar di Ritecs! Untuk menyelesaikan proses registrasi, silakan gunakan kode verifikasi sekali pakai (OTP) di bawah ini.
                </p>
                
                <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <div style="background-color: #f0f0f0; border-radius: 8px; padding: 15px 25px;">
                                <p class="fallback-font" style="font-size: 36px; font-weight: 700; letter-spacing: 5px; color: #1a1a1a; margin: 0;">
                                    {{ $otp }}
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555; margin-top: 30px;">
                    Kode ini hanya berlaku selama 10 menit. Demi keamanan, mohon untuk tidak membagikan kode ini kepada siapa pun.
                </p>
                <p class="fallback-font" style="font-size: 16px; line-height: 1.6; color: #555555;">
                    Jika Anda tidak merasa mendaftar, Anda bisa mengabaikan email ini.
                </p>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px 40px; text-align: center; background-color: #fafafa; border-top: 1px solid #e9ecef; border-radius: 0 0 8px 8px;">
                <p class="fallback-font" style="font-size: 12px; color: #888888; margin: 0;">
                    &copy; {{ date('Y') }} Ritecs. All rights reserved.
                </p>
                <p class="fallback-font" style="font-size: 12px; color: #888888; margin: 5px 0 0 0;">
                    Semarang, Jawa Tengah, Indonesia
                </p>
            </td>
        </tr>
    </table>

</body>
</html>