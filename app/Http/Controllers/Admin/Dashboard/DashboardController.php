<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Tambahkan ini

use App\Models\Transaction;
use App\Models\Membership;
use App\Models\Book;
use App\Models\Contact;
use App\Models\AdminLog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. RINGKASAN ATAS (STAT CARD) ---
        $totalRevenue = Transaction::where('status', 'paid')->sum('amount');
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $activeMembers = Membership::where('status', 1)->count();
        $totalDownloads = Book::sum('download_count');

        // --- 2. DATA UNTUK GRAFIK (7 HARI TERAKHIR) ---
        $chartDates = [];
        $dataRevenue = [];
        $dataMembers = [];
        $dataTransactions = [];

        // Loop untuk 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');
            
            // Label Tanggal (Misal: "Mon, 08")
            $chartDates[] = $date->format('D, d');

            // Data Revenue per hari
            $dataRevenue[] = Transaction::whereDate('created_at', $formattedDate)
                                ->where('status', 'paid')
                                ->sum('amount');

            // Data Member Baru per hari
            $dataMembers[] = Membership::whereDate('created_at', $formattedDate)
                                ->count();

            // Data Total Transaksi per hari
            $dataTransactions[] = Transaction::whereDate('created_at', $formattedDate)
                                ->count();
        }

        // --- 3. TABEL & LIST DATA TERBARU ---
        $recentTransactions = Transaction::with('user')
                                ->latest('created_at')
                                ->take(5)
                                ->get();

        $recentMessages = Contact::latest('created_at')->take(5)->get();

        $adminLogs = AdminLog::with('actor')
                        ->latest('created_at')
                        ->take(10)
                        ->get();

        return view('backend.pages.dashboard', compact(
            'totalRevenue',
            'pendingTransactions',
            'activeMembers',
            'totalDownloads',
            'recentTransactions',
            'recentMessages',
            'adminLogs',
            'chartDates',
            'dataRevenue',
            'dataMembers',
            'dataTransactions'
        ));
    }
}