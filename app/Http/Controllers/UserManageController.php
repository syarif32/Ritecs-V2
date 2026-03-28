<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserManageController extends Controller
{
    public function index(Request $request) 
    { 
        $users = User::role('User')
        ->where('acc_status', 1) 
        ->with('membership')
        ->paginate(10); 
    
        if ($request->expectsJson()) {
    
            $usersMobile = User::role('User')->where('acc_status', 1)->with('membership')->get();
            $mapped = $usersMobile->map(function($u) {
                return [
                    'user_id' => $u->user_id,
                    'name' => trim($u->first_name . ' ' . $u->last_name),
                    'email' => $u->email,
                    'phone' => $u->phone,
                    'is_member' => $u->membership ? true : false,
                    'member_number' => $u->membership ? $u->membership->member_number : null,
                    'img_path' => $u->img_path ? asset($u->img_path) : null,
                ];
            });
            return response()->json(['status' => 'success', 'data' => $mapped]);
        }
        // ---------------------------------

        return view('backend.pages.users.users-data', compact('users') , [ 'title' => 'Users Data' ]); 
    }

    public function nonactiveusers(Request $request) 
    {
        $users = User::role('User')
            ->where('acc_status', 0) 
            ->with('membership')
            ->paginate(10);

        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) {
            $usersMobile = User::role('User')->where('acc_status', 0)->with('membership')->get();
            $mapped = $usersMobile->map(function($u) {
                return [
                    'user_id' => $u->user_id,
                    'name' => trim($u->first_name . ' ' . $u->last_name),
                    'email' => $u->email,
                    'phone' => $u->phone,
                    'is_member' => $u->membership ? true : false,
                    'member_number' => $u->membership ? $u->membership->member_number : null,
                    'img_path' => $u->img_path ? asset($u->img_path) : null,
                ];
            });
            return response()->json(['status' => 'success', 'data' => $mapped]);
        }
        // ---------------------------------

        return view('backend.pages.users.nonactiveusers-data', compact('users'), [
            'title' => 'NonActive Users Data'
        ]);
    }

    public function create()
    {
        return view('backend.pages.users.add-users', [
            'title' => 'Add User'
        ]);
    }

    public function store(Request $request)
    {
        // LOGIKA ASLI TIDAK DISENTUH
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'profile'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ktp'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User($request->except(['password','profile','ktp']));
        $user->password = Hash::make($request->password);

        if ($request->hasFile('profile')) {
            $profileName = time().'_profile.'.$request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->move(public_assets_path('assets/users/profile'), $profileName);
            $user->img_path = 'assets/users/profile/'.$profileName;
        }

        if ($request->hasFile('ktp')) {
            $ktpName = time().'_ktp.'.$request->file('ktp')->getClientOriginalExtension();
            $request->file('ktp')->move(public_assets_path('assets/users/identity'), $ktpName);
            $user->ktp_path = 'assets/users/identity/'.$ktpName;
        }

        $user->save();
        $user->assignRole('User');

        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'User berhasil ditambahkan.']);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::role('User')->findOrFail($id);
        return view('backend.pages.users.edit-users', compact('user'), [
            'title' => 'Edit Data User'
        ]);
    }

    public function update(Request $request, $id)
    {
     
        $user = User::role('User')->findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email,'.$user->user_id.',user_id',
            'password'   => 'nullable|min:6',
            'profile'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ktp'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->fill($request->except(['password','profile','ktp']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            if ($user->img_path && File::exists(public_assets_path($user->img_path))) {
                File::delete(public_assets_path($user->img_path));
            }
            $profileName = time().'_profile.'.$request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->move(public_assets_path('assets/users/profile'), $profileName);
            $user->img_path = 'assets/users/profile/'.$profileName;
        }

        if ($request->hasFile('ktp')) {
            if ($user->ktp_path && File::exists(public_assets_path($user->ktp_path))) {
                File::delete(public_assets_path($user->ktp_path));
            }
            $ktpName = time().'_ktp.'.$request->file('ktp')->getClientOriginalExtension();
            $request->file('ktp')->move(public_assets_path('assets/users/identity'), $ktpName);
            $user->ktp_path = 'assets/users/identity/'.$ktpName;
        }

        $user->save();

        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'User berhasil diperbarui.']);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, $id) // <- Tambah Request
    {
        $user = User::role('User')->findOrFail($id);
        $user->acc_status = 0;
        $user->save();

        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'User berhasil dinonaktifkan.']);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dinonaktifkan.');
    }

    public function restore(Request $request, $id) // <- Tambah Request
    {
        $user = User::role('User')->findOrFail($id);
        $user->acc_status = 1;
        $user->save();

        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'User berhasil diaktifkan kembali.']);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diaktifkan kembali.');
    }

    public function makeMember(Request $request, $id)
    {
        $request->validate([
            'member_number' => 'required|unique:memberships,member_number',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ]);
    
        $user = User::findOrFail($id);
    
        if ($user->membership) {
            if ($request->expectsJson()) return response()->json(['status' => 'error', 'message' => 'User sudah memiliki membership.'], 400);
            return back()->with('error', 'User ini sudah memiliki membership aktif.');
        }
    
        Membership::create([
            'user_id'       => $user->user_id,
            'member_number' => $request->member_number,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'status'        => 1,
        ]);
    
        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'Membership berhasil ditambahkan.']);
        return back()->with('success', 'Membership berhasil ditambahkan untuk user ini.');
    }
}