<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;


class ManageUserMembershipController extends Controller
{
    // INDEX
    public function index()
    {
        $memberships = Membership::with('user')->orderBy('created_at','desc')->paginate(10);
        return view('backend.pages.manage-user-membership.index', compact('memberships'), ['title' => 'User Membership Data']);
    }

    // CREATE
    public function create()
    {
        $users = User::whereDoesntHave('membership')->get();
        return view('backend.pages.manage-user-membership.create', compact('users'), ['title' => 'Add User Membership']);
    }

    
    public function store(Request $request)
    {
        // Ambil aksi dari submit kedua (jika ada)
        $action = $request->membership_action;
    
        // Jika klik batal
        if ($action === "cancel") {
            return redirect()->route('admin.manageUserMemberships.create')
                ->with('info', 'Aksi dibatalkan.');
        }
    
        // Submit kedua: Relasi User
        if ($action === "user_relation") {
            $user = User::find($request->selected_user_id);
            if (!$user) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
            // ⇩ Tambahan notifikasi error jika user sudah punya membership
            if ($user->membership) {
                return redirect()->back()
                    ->with('error', 'User ini sudah memiliki membership — tidak dapat menambahkan dua kali.')
                    ->withInput();
            }
    
            Membership::create([
                'user_id' => $user->user_id,
                'guest_first_name' => null,
                'guest_last_name' => null,
                'guest_email' => null,
                'guest_institution' => null,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'member_number' => $request->member_number,
                'status' => $request->status,
            ]);
    
            return redirect()->route('admin.manageUserMemberships.index')
                ->with('success', 'Membership berhasil ditambahkan untuk user.');
        }
    
        // Submit kedua: Guest dengan email sama
        if ($action === "guest_force") {
            // Cegah 1 guest punya membership lebih dari 1
            $existGuest = Membership::where('guest_email', $request->guest_email)->first();
            if ($existGuest) {
                return redirect()->back()
                    ->with('error', 'Email ini sudah memiliki membership (Type : Guest) — tidak dapat menambahkan dua kali!')
                    ->withInput();
            }
    
            Membership::create([
                'user_id' => null,
                'guest_first_name' => $request->guest_first_name,
                'guest_last_name' => $request->guest_last_name,
                'guest_email' => $request->guest_email,
                'guest_institution' => $request->guest_institution,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'member_number' => $request->member_number,
                'status' => $request->status,
            ]);
    
            return redirect()->route('admin.manageUserMemberships.index')
                ->with('success', 'Membership guest berhasil ditambahkan.');
        }
    
        // Submit pertama — cek email
        $userMatch = User::where('email', $request->guest_email)->first();
        if ($userMatch) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'membership_email_conflict' => true,
                    'conflict_user' => $userMatch
                ]);
        }
    
        // Jika tidak ada email yang bentrok → guest normal
        Membership::create($request->only([
            'guest_first_name',
            'guest_last_name',
            'guest_email',
            'guest_institution',
            'start_date',
            'end_date',
            'member_number',
            'status'
        ]));
    
        return redirect()->route('admin.manageUserMemberships.index')
            ->with('success', 'Membership berhasil ditambahkan.');
    }


    // EDIT
    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
    
        // User yang BELUM punya membership, plus user yang sedang terpilih (agar tetap muncul di dropdown)
        $users = User::whereDoesntHave('membership')
            ->orWhere('user_id', $membership->user_id)
            ->get();
    
        return view('backend.pages.manage-user-membership.edit',
            compact('membership','users'),
            ['title' => 'Edit User Membership']
        );
    }


    // UPDATE
    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);
    
        $action = $request->membership_action;
    
        // Jika admin klik BATAL di modal
        if ($action === "cancel") {
            return redirect()->back()->with('info', 'Aksi dibatalkan.');
        }
    
        // ===========================
        // 1) Relasi User (Confirm Modal)
        // ===========================
        if ($action === "user_relation") {
    
            $user = User::find($request->selected_user_id);
    
            if (!$user) {
                return back()->with('error', 'User tidak ditemukan.');
            }
    
            // Cek apakah user sudah punya membership LAIN
            $exist = Membership::where('user_id', $user->user_id)
                    ->where('membership_id', '!=', $id)
                    ->first();
    
            if ($exist) {
                return back()->with('error', 'User ini sudah memiliki membership lain.');
            }
    
            // Update → jadikan membership milik user
            $membership->update([
                'user_id' => $user->user_id,
                'guest_first_name' => null,
                'guest_last_name' => null,
                'guest_email' => null,
                'guest_institution' => null,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'member_number' => $request->member_number,
                'status' => $request->status,
            ]);
    
            return redirect()->route('admin.manageUserMemberships.index')
                ->with('success', 'Membership berhasil diperbarui (Relasi User).');
        }
    
    
        // ===========================
        // 2) Guest Force (Confirm Modal)
        // ===========================
        if ($action === "guest_force") {
    
            // Cek guest email tidak dipakai oleh membership lain
            $exist = Membership::where('guest_email', $request->guest_email)
                ->where('membership_id', '!=', $id)
                ->first();
            
            if ($exist) {
                return back()->with('error', 'Email guest ini sudah memiliki membership lain.');
            }
    
            $membership->update([
                'user_id' => null,
                'guest_first_name' => $request->guest_first_name,
                'guest_last_name' => $request->guest_last_name,
                'guest_email' => $request->guest_email,
                'guest_institution' => $request->guest_institution,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'member_number' => $request->member_number,
                'status' => $request->status,
            ]);
    
            return redirect()->route('admin.manageUserMemberships.index')
                ->with('success', 'Membership guest berhasil diperbarui.');
        }
    
    
        // ===========================
        // 3) Submit pertama — check conflict
        // ===========================
        $userMatch = User::where('email', $request->guest_email)
            ->where('user_id', '!=', $membership->user_id) // kalau edit email sama dgn user lama → aman
            ->first();
    
        if ($userMatch) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'membership_email_conflict' => true,
                    'conflict_user' => $userMatch,
                ]);
        }
    
        // ===========================
        // 4) Normal Update Guest or User existing
        // ===========================
    
        // Jika membership sebelumnya milik user
        if ($membership->user_id) {
            // Jangan boleh ganti ke guest tanpa confirm → tapi kalau tidak conflict, tetap guest normal
            $membership->update([
                'user_id' => null,
                'guest_first_name' => $request->guest_first_name,
                'guest_last_name' => $request->guest_last_name,
                'guest_email' => $request->guest_email,
                'guest_institution' => $request->guest_institution,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'member_number' => $request->member_number,
                'status' => $request->status,
            ]);
        } 
        else {
            // Guest update normal
            $membership->update($request->only([
                'guest_first_name',
                'guest_last_name',
                'guest_email',
                'guest_institution',
                'start_date',
                'end_date',
                'member_number',
                'status',
            ]));
        }
        
        if ($request->membership_action === 'convert_to_guest') {
            $membership->user_id = null;
        
            // guest fields harus tetap terisi minimal email
            if (!$request->guest_email) {
                return back()->with('error', 'Email guest harus diisi saat un-relasi user.');
            }
        
            $membership->guest_first_name = $request->guest_first_name;
            $membership->guest_last_name = $request->guest_last_name;
            $membership->guest_email = $request->guest_email;
            $membership->guest_institution = $request->guest_institution;
            $membership->save();
        
            return redirect()
                ->route('admin.manageUserMemberships.index')
                ->with('success', 'Membership berhasil diubah menjadi guest.');
        }

    
        return redirect()->route('admin.manageUserMemberships.index')
            ->with('success', 'Membership berhasil diperbarui.');
    }

    // DELETE → hanya nonaktifkan
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->status = 0;
        $membership->save();

        return redirect()->route('admin.manageUserMemberships.index')->with('success', 'Membership deactivated successfully.');
    }

    // RESTORE
    public function restore($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->status = 1;
        $membership->save();

        return redirect()->route('admin.manageUserMemberships.index')->with('success', 'Membership activated successfully.');
    }

    // FORCE DELETE → hapus data membership permanen
    public function forceDelete($id)
    {
        $membership = Membership::findOrFail($id);

        // Optional: jika mau cek dulu apakah membership masih aktif
        if ($membership->status == 1) {
            return redirect()->route('admin.manageUserMemberships.index')
                ->with('error', 'Tidak bisa menghapus membership yang masih aktif. Nonaktifkan dulu.');
        }

        $membership->delete();

        return redirect()->route('admin.manageUserMemberships.index')
            ->with('success', 'Membership deleted permanently.');
    }

}
