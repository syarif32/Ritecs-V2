<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivationRequest; 

class OtpVerificationController extends Controller
{
    private $otpWaitTime = 10; 

    public function showVerificationForm($userId)
    {
        // Kita kirim variabel 'timer' ke view
        return view('pages.auth.otp-verify', [
            'user_id' => $userId,
            'timer'   => $this->otpWaitTime 
        ]);
    }

    /**
     * Memverifikasi OTP yang dimasukkan user.
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'otp'     => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'otp_errors')->withInput();
        }

        $user = User::find($request->user_id);

        // SECURITY UPDATE: Cek Rate Limit (Brute Force Protection)
        $failKey = 'otp_fails_' . $user->user_id;
        $maxFails = 5;

        if (Cache::get($failKey, 0) >= $maxFails) {
            return back()->withErrors(
                ['otp' => 'Anda telah salah memasukkan OTP 5 kali. Silakan minta kode baru.'],
                'otp_errors'
            );
        }

        $cacheKey = 'otp_for_user_' . $user->user_id;
        $cachedOtp = Cache::get($cacheKey);

        // SECURITY UPDATE: Validasi OTP dan Counter Kegagalan
        if (!$cachedOtp || $cachedOtp != $request->otp) {
            // Increment counter kegagalan
            Cache::increment($failKey);
            
            // Set expire counter reset otomatis  (10 menit)
            if (!Cache::has($failKey)) {
                 Cache::put($failKey, 1, now()->addMinutes(10));
            }
            
            $currentFails = Cache::get($failKey);
            $attemptsLeft = $maxFails - $currentFails;

            return back()->withErrors(
                ['otp' => "Kode OTP salah atau kedaluwarsa. Sisa percobaan: $attemptsLeft"], 
                'otp_errors' 
            );
        }

        
        Cache::forget($cacheKey);
        Cache::forget($failKey); 

        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);
        return redirect()->route('profile.dashboard')->with('success', 'Verifikasi berhasil! Selamat datang.');
    }

    /**
     * Mengirim ulang kode OTP baru.
     */
    public function resend($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors('Terjadi kesalahan, user tidak ditemukan.');
        }
        
        // Rate Limiting Logic
        $resendLimitKey = 'otp_resend_count_' . $user->user_id;
        $maxAttempts = 3;

        // Ambil jumlah percobaan saat ini (default 0 jika belum ada)
        $currentAttempts = Cache::get($resendLimitKey, 0);

        // Cek apakah sudah mencapai batas
        if ($currentAttempts >= $maxAttempts) {
            return back()->with('error', 'Anda telah mencapai batas maksimum kirim ulang OTP (3x). Demi keamanan, silakan coba lagi besok (24 jam).');
        }

        // Logic Increment Counter
        if (!Cache::has($resendLimitKey)) {
            Cache::put($resendLimitKey, 1, now()->addDay());
        } else {
            Cache::increment($resendLimitKey);
        }

        $cacheKey = 'otp_for_user_' . $user->user_id;
        Cache::forget($cacheKey);

        // SECURITY UPDATE: Reset counter kegagalan karena user minta OTP baru
        Cache::forget('otp_fails_' . $user->user_id);

        // SECURITY UPDATE: Gunakan random_int
        $otp = random_int(100000, 999999);
        
        // Simpan OTP baru
        Cache::put($cacheKey, $otp, now()->addMinutes(10));

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors('Gagal mengirim email. Silakan coba lagi nanti.');
        }

        // UPDATE: Menggunakan variabel dinamis $this->otpWaitTime
        return back()->with('success', 'Kode OTP baru telah berhasil dikirim ulang!')->with('resend_timer', $this->otpWaitTime);
    }

    public function requestManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'reason'  => 'required|string',
            'other_reason_detail' => 'nullable|string|max:255',
        ]);

        $user = User::find($request->user_id);
        
        
        $lastRequest = ActivationRequest::where('user_id', $user->user_id)
            ->latest()
            ->first();

        if ($lastRequest && $lastRequest->created_at->diffInHours(now()) < 24) {
            return back()->with('error', 'Anda sudah mengirim permintaan. Mohon tunggu admin memprosesnya (maks 1x24 jam).');
        }

       
        $disposableDomains = ['temp-mail.org', 'yopmail.com', 'mailinator.com', '10minutemail.com', 'guerrillamail.com'];
        $emailDomain = substr(strrchr($user->email, "@"), 1);

        if (in_array($emailDomain, $disposableDomains)) {
            return back()->with('error', 'Mohon gunakan email resmi/pribadi yang valid, bukan email sementara.');
        }


        
        // Bersihkan input 'reason' dari tag HTML/Script
        $safeReason = strip_tags($request->reason);
        
       
        $finalReason = $safeReason;
        
       
        if ($request->reason == 'Lainnya' && $request->filled('other_reason_detail')) {
            $safeDetail = strip_tags($request->other_reason_detail);
            $finalReason = 'Lainnya: ' . $safeDetail;
        }

        // Simpan data yang sudah bersih
        ActivationRequest::create([
            'user_id' => $user->user_id,
            'reason'  => $finalReason, 
            'status'  => 'pending'
        ]);

        return back()->with('activation_success', 'Permintaan aktivasi manual terkirim! Admin kami akan segera memverifikasi akun Anda dalam 1x24 jam.');
    }
}