<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Models\User;
use App\Mail\SendOtpMail;
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

        // Cek status verifikasi email
        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Akun belum diverifikasi. Silakan request OTP terlebih dahulu.'], 403);
        }

        // Cek status akun (aktif/nonaktif)
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
        // Karena form request sudah mengecek 'unique:users,email', 
        // kita bisa langsung create user baru yang belum diverifikasi
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'acc_status' => 1 
        ]);
        
        $user->assignRole('user');

        // Generate OTP menggunakan random_int untuk keamanan ekstra
        $otp = random_int(100000, 999999);
        
        // Simpan OTP ke dalam Cache selama 10 menit
        Cache::put('otp_for_user_'.$user->user_id, $otp, now()->addMinutes(10));

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim email OTP, pastikan konfigurasi SMTP benar.'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.',
            'user_id' => $user->user_id // Dikirim agar mobile app tahu ID user untuk proses verifikasi nanti
        ], 201);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar.'], 404);
        }

        // Ambil OTP dari Cache
        $cachedOtp = Cache::get('otp_for_user_'.$user->user_id);

        if (!$cachedOtp || $cachedOtp != $request->otp_code) {
            return response()->json(['message' => 'Kode OTP salah atau sudah kedaluwarsa.'], 400);
        }

        // OTP Benar, aktifkan akun
        $user->update([
            'email_verified_at' => now(),
        ]);

        // Hapus OTP dari Cache agar tidak bisa dipakai ulang
        Cache::forget('otp_for_user_'.$user->user_id);

        // Cetak Token Sanctum
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
}