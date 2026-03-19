<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // --- SECURITY UPDATE: RATE LIMITING ---
        
        $key = 'forgot-password:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak permintaan. Silakan coba lagi dalam $seconds detik.",
            ]);
        }
        
   
        RateLimiter::hit($key, 60); 
      

        $status = Password::sendResetLink($request->only('email'));

        // --- SECURITY UPDATE: ANTI USER ENUMERATION ---
        
        return back()->with(['status' => 'Jika email tersebut terdaftar, kami telah mengirimkan tautan reset password.']);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('pages.auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
                
                Auth::login($user); 
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('home')->with('status', 'Password berhasil diubah, Anda telah login!');
        }
        
        
        if ($status === Password::INVALID_TOKEN) {
            return response()->view('pages.404link', [], 404);
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}