<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Models\User;
use App\Models\ActivationRequest; 
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Kredensial tidak valid.'], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.',
                'user_id' => $user->user_id
            ], 403);
        }

        if ($user->acc_status != 1) {
            return response()->json(['message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'], 403);
        }

        $token = $user->createToken('MobileAppToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function requestOtp(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'acc_status' => 1 
        ]);
        
        $user->assignRole('user');

        // SECURITY: Set limit resend OTP untuk user baru
        Cache::put('otp_resend_count_' . $user->user_id, 1, now()->addDay());

        // Generate OTP
        $otp = random_int(100000, 999999);
        Cache::put('otp_for_user_'.$user->user_id, $otp, now()->addMinutes(10));

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim email OTP, pastikan konfigurasi SMTP benar.'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.',
            'user_id' => $user->user_id 
        ], 201);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar.'], 404);
        }

        // SECURITY UPDATE: Cek Rate Limit (Brute Force Protection)
        $failKey = 'otp_fails_' . $user->user_id;
        $maxFails = 5;

        if (Cache::get($failKey, 0) >= $maxFails) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda telah salah memasukkan OTP 5 kali. Silakan minta kode baru.'
            ], 429); // 429 Too Many Requests
        }

        $cacheKey = 'otp_for_user_' . $user->user_id;
        $cachedOtp = Cache::get($cacheKey);

        // SECURITY UPDATE: Validasi OTP dan Counter Kegagalan
        if (!$cachedOtp || $cachedOtp != $request->otp_code) {
            // Increment counter kegagalan
            if (!Cache::has($failKey)) {
                 Cache::put($failKey, 1, now()->addMinutes(10));
            } else {
                 Cache::increment($failKey);
            }
            
            $currentFails = Cache::get($failKey);
            $attemptsLeft = $maxFails - $currentFails;

            return response()->json([
                'status' => 'error',
                'message' => "Kode OTP salah atau kedaluwarsa. Sisa percobaan: $attemptsLeft"
            ], 400);
        }

        // OTP Benar, hapus cache fail & cache OTP
        Cache::forget($cacheKey);
        Cache::forget($failKey); 

        $user->update([
            'email_verified_at' => now(),
        ]);

        $token = $user->createToken('MobileAppToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Verifikasi berhasil.',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    // ENDPOINT BARU: Resend OTP dengan Rate Limiting
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Akun sudah diverifikasi.'], 400);
        }

        // Rate Limiting Logic (Maks 3x per hari)
        $resendLimitKey = 'otp_resend_count_' . $user->user_id;
        $maxAttempts = 3;
        $currentAttempts = Cache::get($resendLimitKey, 0);

        if ($currentAttempts >= $maxAttempts) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda telah mencapai batas maksimum kirim ulang OTP (3x). Silakan coba lagi besok (24 jam).'
            ], 429);
        }

        // Increment Counter
        if (!Cache::has($resendLimitKey)) {
            Cache::put($resendLimitKey, 1, now()->addDay());
        } else {
            Cache::increment($resendLimitKey);
        }

        // Reset kegagalan verifikasi sebelumnya
        Cache::forget('otp_fails_' . $user->user_id);

        $cacheKey = 'otp_for_user_' . $user->user_id;
        $otp = random_int(100000, 999999);
        Cache::put($cacheKey, $otp, now()->addMinutes(10));

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim email OTP. Silakan coba lagi.'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Kode OTP baru telah berhasil dikirim ulang!',
            'resend_timer' => 10
        ], 200);
    }

   
    public function requestManual(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'reason'  => 'required|string',
            'other_reason_detail' => 'nullable|string|max:255',
        ]);

        $user = User::where('email', $request->email)->first();
        
        $lastRequest = ActivationRequest::where('user_id', $user->user_id)
            ->latest()
            ->first();

        if ($lastRequest && $lastRequest->created_at->diffInHours(now()) < 24) {
            return response()->json(['message' => 'Anda sudah mengirim permintaan. Mohon tunggu admin memprosesnya (maks 1x24 jam).'], 429);
        }

        $disposableDomains = ['temp-mail.org', 'yopmail.com', 'mailinator.com', '10minutemail.com', 'guerrillamail.com'];
        $emailDomain = substr(strrchr($user->email, "@"), 1);

        if (in_array($emailDomain, $disposableDomains)) {
            return response()->json(['message' => 'Mohon gunakan email resmi/pribadi yang valid, bukan email sementara.'], 400);
        }

        $finalReason = strip_tags($request->reason);
        if ($request->reason == 'Lainnya' && $request->filled('other_reason_detail')) {
            $finalReason = 'Lainnya: ' . strip_tags($request->other_reason_detail);
        }

        ActivationRequest::create([
            'user_id' => $user->user_id,
            'reason'  => $finalReason, 
            'status'  => 'pending'
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Permintaan aktivasi manual terkirim! Admin kami akan segera memverifikasi akun Anda dalam 1x24 jam.'
        ], 200);
    }
    
    
    public function googleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'google_id' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'img_path' => 'nullable|string'
        ]);

      
        $user = User::where('google_id', $request->google_id)
                    ->orWhere('email', $request->email)
                    ->first();

        if ($user) {
          
            $user->update([
                'google_id' => $request->google_id,
                'email_verified_at' => $user->email_verified_at ?? now(),
                'img_path' => $user->img_path ?? $request->img_path
            ]);
        } else {
         
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'google_id'  => $request->google_id,
                'img_path'   => $request->img_path,
                'email_verified_at' => now(), 
                'password'   => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                'acc_status' => 1
            ]);
            
            $user->assignRole('user');
        }

      
        $token = $user->createToken('MobileAppToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Google berhasil',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }
}