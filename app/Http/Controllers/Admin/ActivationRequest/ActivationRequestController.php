<?php

namespace App\Http\Controllers\Admin\ActivationRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;
class ActivationRequestController extends Controller
{
    /**
     * Menampilkan daftar request yang masih PENDING
     */
    public function index()
    {
       
        $requests = ActivationRequest::with('user')
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('backend.pages.activation.index', compact('requests'));
    }

    /**
     * Setujui (Approve) & Aktifkan User
     */
    public function approve($id)
    {
        $activationReq = ActivationRequest::findOrFail($id);

        DB::transaction(function () use ($activationReq) {
           
            $user = $activationReq->user;
            
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
            }

            
            $activationReq->update([
                'status' => 'approved',
                'processed_by' => Auth::user()->user_id 
            ]);
        });

        return back()->with('success', 'User berhasil diaktifkan secara manual.');
    }

    /**
     * Tolak (Reject)
     */
    public function reject(Request $request, $id)
    {
        $activationReq = ActivationRequest::findOrFail($id);

        $activationReq->update([
            'status' => 'rejected',
            'processed_by' => Auth::user()->user_id
        ]);

        return back()->with('error', 'Permintaan aktivasi ditolak.');
    }
}
