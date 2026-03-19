<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL; 
use App\Mail\SendOtpMail;

class AuthController extends Controller
{
    private function handleOtpSending($user)
    {
        $resendLimitKey = 'otp_resend_count_' . $user->user_id;
        $maxAttempts = 3;

        $currentAttempts = Cache::get($resendLimitKey, 0);

        if ($currentAttempts >= $maxAttempts) {
            return 'Limit OTP tercapai. Silakan gunakan kode terakhir atau tunggu 24 jam.';
        }

        // SECURITY UPDATE: Gunakan random_int
        $otp = random_int(100000, 999999);
        Cache::put('otp_for_user_'.$user->user_id, $otp, now()->addMinutes(10));

        if (!Cache::has($resendLimitKey)) {
            Cache::put($resendLimitKey, 1, now()->addDay());
        } else {
            Cache::increment($resendLimitKey);
        }

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
        }

        return 'Kode OTP baru telah dikirim ke email Anda.';
    }

    public function showLoginMessage()
    {
        return redirect()->route('home')->with('session_expired', 'Sesi Anda telah berakhir. Silakan login kembali untuk melanjutkan.');
    }

    public function register(Request $request)
    {
        $request->validate(['email' => ['required', 'string', 'email', 'max:255']]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && !$existingUser->email_verified_at) {
            $message = $this->handleOtpSending($existingUser);
            $statusType = str_contains($message, 'Limit') ? 'error' : 'success';

            // SECURITY UPDATE: Gunakan Signed Route agar ID tidak bisa diubah di URL
            $signedUrl = URL::temporarySignedRoute(
                'otp.verify.show',
                now()->addMinutes(30),
                ['userId' => $existingUser->user_id]
            );

            return redirect()->to($signedUrl)
                ->with($statusType, 'Email ini sudah terdaftar tapi belum diverifikasi. ' . $message);
        }

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['unique:users,email'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        Cache::put('otp_resend_count_' . $user->user_id, 1, now()->addDay());
        
        // SECURITY UPDATE: Gunakan random_int
        $otp = random_int(100000, 999999);
        Cache::put('otp_for_user_'.$user->user_id, $otp, now()->addMinutes(10));
        
        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            // Optional: Handle error sending mail
        }

        // SECURITY UPDATE: Gunakan Signed Route
        $signedUrl = URL::temporarySignedRoute(
            'otp.verify.show',
            now()->addMinutes(30),
            ['userId' => $user->user_id]
        );

        return redirect()->to($signedUrl)
            ->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->email_verified_at) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = $this->handleOtpSending($user);
                $statusType = str_contains($message, 'Limit') ? 'error' : 'success';

                // SECURITY UPDATE: Gunakan Signed Route
                $signedUrl = URL::temporarySignedRoute(
                    'otp.verify.show',
                    now()->addMinutes(30),
                    ['userId' => $user->user_id]
                );

                return redirect()->to($signedUrl)
                    ->with($statusType, 'Akun Anda belum diverifikasi. ' . $message);
            }

            $request->session()->regenerate();

            if ($user->acc_status != 1) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
                ])->onlyInput('email');
            }

            if ($user->hasRole('Admin')) {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('profile.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Log Out Berhasil.');
    }
}