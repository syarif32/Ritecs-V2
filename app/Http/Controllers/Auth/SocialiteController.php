<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
   
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
         
                $updateData = [
                    'google_id' => $googleUser->getId(), 
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ];

                if (empty($user->img_path)) {
                    $updateData['img_path'] = $googleUser->getAvatar();
                }

                $user->update($updateData);
                
                Auth::login($user);

            } else {
                
                
                $nameParts = explode(' ', $googleUser->getName(), 2);
                
                $newUser = User::create([
                    'first_name' => $nameParts[0],
                    'last_name'  => $nameParts[1] ?? null,
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(), 
                    'img_path'   => $googleUser->getAvatar(), 
                    'email_verified_at' => now(),
                    'password'   => Hash::make(Str::random(16)) 
                ]);

                $newUser->assignRole('user');
                Auth::login($newUser);
            }

            return redirect()->route('profile.dashboard');

        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Gagal login via Google.');
        }
    }
}