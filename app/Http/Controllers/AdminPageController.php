<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Journal;
use App\Models\Writer;
use App\Models\Keyword;
use App\Models\User;
use App\Models\Membership;
use App\Models\Transaction;
use App\Models\AdminLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminPageController extends Controller
{
    public function dashboard()
    {
        // 1. REVENUE DATA
        $totalRevenue = Transaction::where('status', 'paid')->sum('amount');
        
        // Revenue bulan ini vs bulan lalu (untuk Balance growth)
        $thisMonthRevenue = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        
        $lastMonthRevenue = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');
        
        // Hitung pertumbuhan bulan ini vs bulan lalu
        if ($lastMonthRevenue > 0) {
            $monthlyGrowth = round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        } else {
            $monthlyGrowth = $thisMonthRevenue > 0 ? 100 : 0;
        }
        
        // Transaksi sukses bulan ini (untuk radial chart)
        $successTransactionsThisMonth = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Total transaksi bulan ini (untuk menghitung persentase)
        $totalTransactionsThisMonth = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Persentase success rate
        $successRate = $totalTransactionsThisMonth > 0 
            ? round(($successTransactionsThisMonth / $totalTransactionsThisMonth) * 100, 1) 
            : 0;
        
        // Cost dan Revenue breakdown
        $thisWeekRevenue = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->sum('amount');
        
        $lastWeekRevenue = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->sum('amount');
        
        // Hitung growth dengan lebih akurat
        if ($lastWeekRevenue > 0) {
            $revenueGrowth = round((($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100, 1);
        } else {
            // Jika minggu lalu 0, tapi minggu ini ada revenue
            $revenueGrowth = $thisWeekRevenue > 0 ? 100 : 0;
        }

        // 2. KONTEN & PENERBITAN
        $totalBooks = Book::count();
        $totalJournals = Journal::count();
        $totalWriters = Writer::count();
        $totalKeywords = Keyword::count();
        $totalContent = $totalBooks + $totalJournals;

        // 3. USER & MEMBERSHIP
        $totalUsers = User::count();
        $activeMemberships = Membership::where('status', 1)->whereNotNull('user_id')->count();
        $regularUsers = $totalUsers - $activeMemberships;
        $guestMemberships = Membership::where('status', 1)->whereNull('user_id')->count();

        // 4. AREA CHART DATA (30 hari terakhir)
        $dailyTransactions = Transaction::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format untuk ApexCharts
        $chartDates = [];
        $chartRevenue = [];
        $chartTransactions = [];
        
        foreach ($dailyTransactions as $transaction) {
            $chartDates[] = Carbon::parse($transaction->date)->format('d M Y');
            $chartRevenue[] = $transaction->total;
            $chartTransactions[] = $transaction->count;
        }

        // Stats untuk card balance
        $todayRevenue = Transaction::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
        
        // Monthly target (bisa disesuaikan atau diambil dari settings)
        $monthlyTarget = 10000000; // 10 juta rupiah
        
        $totalCompletions = Transaction::where('status', 'paid')->count();
        $totalPending = Transaction::where('status', 'pending')->count();
        $conversionRate = ($totalCompletions + $totalPending) > 0 
            ? round(($totalCompletions / ($totalCompletions + $totalPending)) * 100, 1) 
            : 0;

        // 5. RECENT ACTIVITY
        $recentActivities = AdminLog::with(['actor', 'target'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 6. RECENT DATA (transaksi terbaru)
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('backend.pages.dashboard', [
            'title' => 'Dashboard',
            
            // Revenue Card
            'totalRevenue' => $totalRevenue,
            'monthlyGrowth' => $monthlyGrowth,
            'successTransactionsThisMonth' => $successTransactionsThisMonth,
            'successRate' => $successRate,
            'revenueGrowth' => $revenueGrowth,
            'thisWeekRevenue' => $thisWeekRevenue,
            
            // Content Card
            'totalContent' => $totalContent,
            'totalBooks' => $totalBooks,
            'totalJournals' => $totalJournals,
            'totalWriters' => $totalWriters,
            'totalKeywords' => $totalKeywords,
            
            // User Card
            'totalUsers' => $totalUsers,
            'regularUsers' => $regularUsers,
            'activeMemberships' => $activeMemberships,
            'guestMemberships' => $guestMemberships,
            
            // Balance Chart
            'chartDates' => json_encode($chartDates),
            'chartRevenue' => json_encode($chartRevenue),
            'chartTransactions' => json_encode($chartTransactions),
            'todayRevenue' => $todayRevenue,
            'monthlyTarget' => $monthlyTarget,
            'totalCompletions' => $totalCompletions,
            'conversionRate' => $conversionRate,
            
            // Activity & Recent Data
            'recentActivities' => $recentActivities,
            'recentTransactions' => $recentTransactions,
        ]);
    }

    public function maintenance()
    {
        return view('backend.pages.maintenance.index');
    }
}