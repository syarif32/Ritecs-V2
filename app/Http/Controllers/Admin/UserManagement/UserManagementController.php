<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Log;  
use App\Models\AdminLog;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->select('users.*') 
            
           
            ->selectSub(function ($query) {
                $query->selectRaw('1')
                    ->from('model_has_roles')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->whereColumn('model_has_roles.model_id', 'users.user_id') 
                    ->where('roles.name', 'Admin')
                    ->limit(1);
            }, 'is_admin_priority')
            
            
            ->orderByRaw("CASE WHEN email = 'admin@ritecs.com' THEN 0 ELSE 1 END")
            
           
            ->orderByDesc('is_admin_priority') 
            
            
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('backend.pages.usersmanagement.index', [
            'users' => $users,
            'title' => 'Role Management' 
        ]);
    }

    public function logHistory()
    {
        
        $logs = AdminLog::with(['actor', 'target'])->latest()->paginate(15);
        
        return view('backend.pages.usersmanagement.history', [
            'logs' => $logs,
            'title' => 'History Log' 
        ]);
    }

    // Promosi admin
    public function promoteToAdmin(Request $request, $id)
    {
        $request->validate([
            'admin_password' => 'required',
        ]);

        if (!Hash::check($request->admin_password, Auth::user()->password)) {
            return back()->withErrors(['admin_password' => 'Password konfirmasi salah. Tindakan dibatalkan.']);
        }

        $user = User::findOrFail($id);

        if ($user->hasRole('Admin')) {
            return redirect()->back()->with('error', 'User ini sudah menjadi Admin.');
        }

        $user->assignRole('Admin');
        
       
        AdminLog::create([
            'actor_id'    => Auth::user()->user_id, 
            'target_id'   => $user->user_id,
            'action_type' => 'PROMOTE',
            'description' => 'Mempromosikan user menjadi Admin',
        ]);
        

        return redirect()->back()->with('success', 'User ' . $user->email . ' berhasil dijadikan Admin.');
    }

    // Pecat admin
    public function demoteToUser(Request $request, $id)
    {
        $request->validate([
            'admin_password' => 'required',
        ]);

        if (!Hash::check($request->admin_password, Auth::user()->password)) {
            return back()->withErrors(['admin_password' => 'Password konfirmasi salah. Tindakan dibatalkan.']);
        }

        $user = User::findOrFail($id);
        
        if ($user->email === 'admin@ritecs.com') {
            return redirect()->back()->with('error', 'DILARANG: Akun Super Admin Utama (admin@ritecs.com) tidak dapat di-demote oleh siapapun.');
        }
        
        
        if ($user->user_id == Auth::user()->user_id) { 
            return redirect()->back()->with('error', 'Anda tidak bisa mencabut akses Admin Anda sendiri.');
        }

        $user->removeRole('Admin');
        
        if (!$user->hasRole('User')) {
            $user->assignRole('User');
        }

        // Simpan log ke database
        AdminLog::create([
            'actor_id'    => Auth::user()->user_id, 
            'target_id'   => $user->user_id,       
            'action_type' => 'DEMOTE',
            'description' => 'Mencabut akses Admin dari user',
        ]);

        return redirect()->back()->with('success', 'Akses Admin untuk ' . $user->email . ' telah dicabut.');
    }
}