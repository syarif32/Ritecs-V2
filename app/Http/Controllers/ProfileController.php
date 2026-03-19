<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $membership = Membership::where('user_id', $user->user_id)
                    ->where('end_date', '>=', Carbon::now()->toDateString())
                    ->first();

        // return view('profile.dashboard', ['title' => 'Dashboard'], compact('user','membership'));
        return redirect()->route('profile.settings');
    }


    public function settings()
    {
        $user = Auth::user();
        $membership = Membership::where('user_id', $user->user_id)
                    ->where('end_date', '>=', Carbon::now()->toDateString())
                    ->first();
        return view('profile.settings', ['title' => 'Settings'], compact('user','membership'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id()); // pastikan pakai model

        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'email'         => 'required|email|max:150|unique:users,email,' . $user->user_id . ',user_id',
            'nik'           => 'nullable|string|max:50',
            'birthday'      => 'nullable|date',
            'phone'         => 'nullable|string|max:50',
            'address'       => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'institution'   => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:255',
            'ktp_path'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'      => 'nullable|min:8', // opsional
        ]);

        // isi data dasar
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
        $user->email         = $request->email;
        $user->nik           = $request->nik;
        $user->birthday      = $request->birthday;
        $user->phone         = $request->phone;
        $user->address       = $request->address ?? '';
        $user->city          = $request->city ?? '';
        $user->institution   = $request->institution ?? '';
        $user->province      = $request->province ?? '';

        // password opsional
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 📂 Upload KTP
        if ($request->hasFile('ktp_path')) {
            $filename = time().'_'.$request->file('ktp_path')->getClientOriginalName();
        
            $destination = public_assets_path('assets/users/identity');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
        
            // Hapus file lama jika ada
            if ($user->ktp_path && file_exists(public_assets_path($user->ktp_path))) {
                @unlink(public_assets_path($user->ktp_path));
            }
        
            // Upload file baru
            $request->file('ktp_path')->move($destination, $filename);
            $user->ktp_path = 'assets/users/identity/'.$filename;
        }


        $user->save(); // simpan data

        return redirect()->route('profile.settings')->with('success', 'Data profil berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filename = time().'_'.$request->file('avatar')->getClientOriginalName();

        // // LOCAL (public_path)
        // $request->file('avatar')->move(public_path('assets/users/profile'), $filename);
        // $path = 'assets/users/profile/'.$filename;

        // // hapus lama jika bukan default
        // $default = 'assets/users/profile/profile_default.jpg';
        // if ($user->img_path && $user->img_path !== $default) {
        //     if (file_exists(public_path($user->img_path))) {
        //         @unlink(public_path($user->img_path));
        //     }
        // }

        // HOSTING (public_assets_path)
        $destination = public_assets_path('assets/users/profile');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        $request->file('avatar')->move($destination, $filename);
        $path = 'assets/users/profile/'.$filename;

        // hapus lama jika bukan default
        $default = 'assets/users/profile/profile_default.jpg';
        if ($user->img_path && $user->img_path !== $default) {
            if (file_exists(public_assets_path($user->img_path))) {
                @unlink(public_assets_path($user->img_path));
            }
        }

        
        $user->img_path = $path;
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Foto profil berhasil diperbarui.');
    }






    public function deleteKtp(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($user->ktp_path && file_exists(public_assets_path($user->ktp_path))) {
            @unlink(public_assets_path($user->ktp_path));
        }

        $user->ktp_path = null;
        $user->save();

        return redirect()->back()->with([
            'success' => 'KTP berhasil dihapus.',
            'openModal' => $request->modal ?? null, // kirim info modal yang dipakai
        ]);
    }


}
