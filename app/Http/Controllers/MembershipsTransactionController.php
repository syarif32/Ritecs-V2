<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Membership;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MembershipsTransactionController extends Controller
{
    // List semua transaksi
    // List semua transaksi
    public function index(Request $request) // <- Tambahkan Request
    {
        $transactions = Transaction::with(['user','bank'])
            ->where('validate', 1)
            ->orderBy('created_at','desc')
            ->get();

        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) {
            $mapped = $transactions->map(function($t) {
                return [
                    'id' => $t->id,
                    'user_name' => $t->user ? trim($t->user->first_name . ' ' . $t->user->last_name) : 'Unknown',
                    'email' => $t->user ? $t->user->email : '-',
                    'bank_name' => $t->bank ? $t->bank->name : '-',
                    'sender_name' => $t->sender_name,
                    'amount' => $t->amount,
                    'status' => $t->status,
                    'type' => $t->type, // new / extendedPayments
                    'proof_url' => $t->proof ? asset($t->proof) : null, // Mengirimkan URL penuh gambar
                    'created_at' => $t->created_at->format('d M Y H:i'),
                    'is_extended' => $t->is_extended
                ];
            });
            return response()->json(['status' => 'success', 'data' => $mapped]);
        }
        // ---------------------------------

        return view('backend.pages.memberships.memberships-data', compact('transactions'), ['title' => 'Memberships']);
    }

    // Form edit/verifikasi (Tidak perlu diubah karena mobile pakai pop up)
    public function edit($id)
    {
        $transaction = Transaction::with(['user','bank'])->findOrFail($id);
        return view('backend.pages.memberships.edit-memberships', compact('transaction'), ['title'=>'Verify Transaction']);
    }

     // Update status transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,rejected'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        // LOGIKA ASLI TIDAK DISENTUH
        if ($request->status === 'paid') {
            $existing = Membership::where('user_id', $transaction->user_id)->first();

            if (!$existing) {
                $startDate = Carbon::now();
                $endDate   = $startDate->copy()->addYear();

                $lastMember = Membership::orderBy('membership_id', 'desc')->first();
                if ($lastMember) {
                    $lastNumber = intval(substr($lastMember->member_number, strrpos($lastMember->member_number, '.') + 1));
                } else {
                    $lastNumber = 0;
                }

                $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                $memberNumber = "01." . Carbon::now()->format('Y') . "." . $newNumber;

                $membership = Membership::create([
                    'user_id'       => $transaction->user_id,
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                    'member_number' => $memberNumber,
                    'status'        => 1, 
                ]);

                $transaction->membership_id = $membership->membership_id;
                $transaction->save();
            } else {
                $transaction->membership_id = $existing->membership_id;
                $transaction->save();
            }
        }

        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Status transaksi berhasil diperbarui.']);
        }
        // ---------------------------------

        return redirect()->route('admin.memberships')->with('success','Transaction status updated successfully.');
    }

    // Delete transaksi
    public function delete(Request $request, $id) // <- Tambahkan Request
    {
        $transaction = Transaction::findOrFail($id);
        $membershipId = $transaction->membership_id;
        $transaction->validate = 0;
        $transaction->save();

        if ($membershipId) {
            $membership = Membership::find($membershipId);
            if ($membership) {
                $membership->status = 0;
                $membership->save();
            }
        }

        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'Transaksi dihapus.']);
        return redirect()->route('admin.memberships')->with('success','Transaction deleted and related membership deactivated successfully.');
    }

    // List transaksi nonaktif
    public function trashed()
    {
        $transactions = Transaction::with(['user','bank'])
            ->where('validate', 0)
            ->orderBy('created_at','desc')
            ->get();

        return view('backend.pages.memberships.memberships-trashed', compact('transactions'), [
            'title' => 'Inactive Memberships'
        ]);
    }

    // Restore transaksi
    public function restore($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Aktifkan kembali transaksi
        $transaction->validate = 1;
        $transaction->save();

        // Jika ada membership terkait → aktifkan kembali
        if ($transaction->membership_id) {
            $membership = Membership::find($transaction->membership_id);
            if ($membership) {
                $membership->status = 1; // aktif lagi
                $membership->save();
            }
        }

        return redirect()->route('admin.memberships.trashed')
            ->with('success','Transaction and related membership restored successfully.');
    }
    
    // Perpanjang masa aktif membership
    public function extend($id)
    {
        $transaction = Transaction::with('membership')->findOrFail($id);

        if ($transaction->status === 'paid' 
            && $transaction->type === 'extendedPayments' 
            && $transaction->is_extended == 0) {

            $membership = Membership::find($transaction->membership_id);

            if ($membership) {
                // Tambah 1 tahun dari end_date terakhir
                $membership->end_date = Carbon::parse($membership->end_date)->addYear();
                $membership->status   = 1; 
                $membership->save();

                // Tandai transaksi sudah dipakai extend
                $transaction->is_extended = 1;
                $transaction->save();

                return redirect()->route('admin.memberships')
                    ->with('success', 'Membership diperpanjang 1 tahun.');
            }
        }

        return redirect()->route('admin.memberships')
            ->with('error', 'Perpanjangan gagal atau sudah pernah dilakukan.');
    }



}
