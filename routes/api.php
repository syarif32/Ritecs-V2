<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Admin\ActivationRequest\ActivationRequestController;
use App\Http\Controllers\Admin\UserManagement\UserManagementController;
use App\Http\Controllers\MembershipsTransactionController;
use App\Http\Controllers\PublishedBooksController;
use App\Http\Controllers\PublishedJournalsController; 
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Api\BookController;
use App\Models\MembershipCardSetting;
use App\Models\Membership; 
use App\Models\Book;
use App\Models\Journal;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;

Route::prefix('auth')->group(function () {
    Route::post('/request-otp', [ApiAuthController::class, 'requestOtp']);
    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
    Route::post('/login', [ApiAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

// admin
Route::middleware(['auth:sanctum', 'role:Admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard-stats', function () {
     
        $totalRevenue = Transaction::where('status', 'paid')->sum('amount');
        
        $thisMonthRevenue = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
            
        $lastMonthRevenue = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');
            
        $monthlyGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $monthlyGrowth = round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        } else {
            $monthlyGrowth = $thisMonthRevenue > 0 ? 100 : 0;
        }

        // 2. Hitung Success Rate
        $successTransactionsThisMonth = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
            
        $totalTransactionsThisMonth = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
            
        $successRate = $totalTransactionsThisMonth > 0 
            ? round(($successTransactionsThisMonth / $totalTransactionsThisMonth) * 100, 1) 
            : 0;

        // 3. Hitung Konten
        $totalContent = Book::count() + Journal::count();

        // 4. Hitung Users
        $totalUsers = User::count();
        $activeMemberships = Membership::where('status', 1)->whereNotNull('user_id')->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'totalRevenue' => (int) $totalRevenue,
                'monthlyGrowth' => (float) $monthlyGrowth,
                'successRate' => (float) $successRate,
                'totalContent' => $totalContent,
                'totalUsers' => $totalUsers,
                'activeMemberships' => $activeMemberships
            ]
        ]);
    });
    Route::get('/activation-requests', [ActivationRequestController::class, 'index']);
    Route::put('/activation-requests/{id}/approve', [ActivationRequestController::class, 'approve']);
    
    
    Route::get('/access-management', [\App\Http\Controllers\Admin\UserManagement\UserManagementController::class, 'index']);
    Route::patch('/access-management/{id}/promote', [\App\Http\Controllers\Admin\UserManagement\UserManagementController::class, 'promoteToAdmin']);
    Route::patch('/access-management/{id}/demote', [\App\Http\Controllers\Admin\UserManagement\UserManagementController::class, 'demoteToUser']);
    Route::get('/memberships', [\App\Http\Controllers\MembershipsTransactionController::class, 'index']);
    Route::post('/memberships/{id}/update', [\App\Http\Controllers\MembershipsTransactionController::class, 'update']);
    Route::get('/memberships/trashed', [\App\Http\Controllers\MembershipsTransactionController::class, 'trashed']);
    Route::post('/memberships/{id}/restore', [\App\Http\Controllers\MembershipsTransactionController::class, 'restore']);
    // ... rute admin lainnya ...
    Route::get('/banks', [\App\Http\Controllers\BankController::class, 'index']);
    Route::post('/banks', [\App\Http\Controllers\BankController::class, 'store']);
    Route::get('/banks/{id}/edit', [\App\Http\Controllers\BankController::class, 'edit']);
    Route::put('/banks/{id}', [\App\Http\Controllers\BankController::class, 'update']);
    Route::delete('/banks/{id}', [\App\Http\Controllers\BankController::class, 'destroy']);
    // Kelola Data Users
    Route::get('/users', [\App\Http\Controllers\UserManageController::class, 'index']);
    Route::get('/users/nonactive', [\App\Http\Controllers\UserManageController::class, 'nonactiveusers']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserManageController::class, 'destroy']);
    Route::post('/users/{id}/restore', [\App\Http\Controllers\UserManageController::class, 'restore']);
    Route::post('/users/{id}/make-member', [\App\Http\Controllers\UserManageController::class, 'makeMember']);
    // Kelola Published Books
    Route::get('/published-books', [\App\Http\Controllers\PublishedBooksController::class, 'bookData']);
    Route::get('/published-books/create', [\App\Http\Controllers\PublishedBooksController::class, 'bookCreate']);
    Route::post('/published-books/store', [\App\Http\Controllers\PublishedBooksController::class, 'bookStore']);
    Route::post('/published-books/{id}/update', [\App\Http\Controllers\PublishedBooksController::class, 'bookUpdate']); // POST u/ file upload
    Route::delete('/published-books/{id}/delete', [\App\Http\Controllers\PublishedBooksController::class, 'bookDelete']);
    // Kelola Journals API
    Route::get('/published-journals', [\App\Http\Controllers\PublishedJournalsController::class, 'journalData']);
    Route::get('/published-journals/create', [\App\Http\Controllers\PublishedJournalsController::class, 'journalCreate']);
    Route::post('/store-journal', [\App\Http\Controllers\PublishedJournalsController::class, 'journalStore']);
    Route::post('/update-journal/{id}', [\App\Http\Controllers\PublishedJournalsController::class, 'journalUpdate']);
    Route::delete('/delete-journal/{id}', [\App\Http\Controllers\PublishedJournalsController::class, 'journalDelete']);
});




    
    // user biasa (member)
    // 1. AMBIL DATA PROFIL
    Route::get('/user-profile', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        $membership = \App\Models\Membership::where('user_id', $user->user_id)->where('status', 1)->first();
        $pending = \App\Models\Transaction::where('user_id', $user->user_id)->where('status', 'pending')->first();
        $cardSettings = MembershipCardSetting::getSettings();
        return response()->json([
            'status' => 'success',
            'data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'img_path' => $user->img_path,
                'is_member' => $membership ? true : false,
                'member_number' => $membership ? $membership->member_number : null,
                'nik' => $user->nik,
                'birthday' => $user->birthday,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'province' => $user->province,
                'institution' => $user->institution,
                'ktp_path' => $user->ktp_path,
                'card_image_path' => $cardSettings->front_image_path ? $cardSettings->front_image_path : null,
                'card_back_image_path' => $cardSettings->back_image_path,
                'is_member' => $membership ? true : false,
                'has_pending_transaction' => $pending ? true : false,
            ]
        ]);
    });

    // 2. SIMPAN DATA & KTP
    Route::post('/update-profile', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        
        $user->first_name = $request->first_name ?? $user->first_name;
        $user->last_name = $request->last_name ?? $user->last_name;
        $user->nik = $request->nik ?? $user->nik;
        $user->birthday = $request->birthday ?? $user->birthday;
        $user->phone = $request->phone ?? $user->phone;
        $user->address = $request->address ?? $user->address;
        $user->city = $request->city ?? $user->city;
        $user->province = $request->province ?? $user->province;
        $user->institution = $request->institution ?? $user->institution;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        // TANGKAP FILE KTP
        if ($request->hasFile('ktp_path')) {
            $file = $request->file('ktp_path');
            $filename = time() . '_ktp_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/users/identity');
            if (!file_exists($destination)) mkdir($destination, 0755, true);
            $file->move($destination, $filename);
            $user->ktp_path = 'assets/users/identity/' . $filename;
        }
        
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Data & KTP berhasil diperbarui!']);
    });

    // 3. UPLOAD FOTO PROFIL (AVATAR)
    Route::post('/update-avatar', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_avatar_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/users/profile');
            if (!file_exists($destination)) mkdir($destination, 0755, true);
            $file->move($destination, $filename);
            $user->img_path = 'assets/users/profile/' . $filename;
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Foto profil diperbarui!']);
        }
        return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan'], 400);
    });

    // 4. MEMBERSHIP: Ambil Data Bank
    Route::get('/membership/banks', function() {
        return response()->json([
            'status' => 'success',
            'data' => \App\Models\Bank::all()
        ]);
    });
    Route::post('/membership/register', [\App\Http\Controllers\MembershipController::class, 'submitTransactionApi']);
     Route::get('/user/transactions', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        
        // Mengambil data transaksi berdasarkan user_id yang sedang login
        // Diurutkan dari yang paling baru (descending)
        $transactions = \App\Models\Transaction::where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($trx) {
                // Mapping agar formatnya 100% cocok dengan DTO Kotlin Android
                return [
                    'id' => $trx->id,
                    'bank_name' => $trx->bank_name ?? $trx->sender_bank ?? 'Transfer Bank', // Sesuaikan kolom database
                    'amount' => (int) $trx->amount,
                    'status' => $trx->status,
                    'type' => $trx->type ?? 'membership',
                    'created_at' => $trx->created_at ? $trx->created_at->toDateTimeString() : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    });

});


// Endpoint Publik untuk Beranda
Route::get('/home-data', function () {
    $vision = \App\Models\Setting::where('key', 'page_vision_text')->first();
    $mission = \App\Models\Setting::where('key', 'page_mission_text')->first();
    
    return response()->json([
        'status' => 'success',
        'data' => [
            'vision' => $vision->value ?? 'Visi belum diatur.',
            'mission' => $mission->value ?? 'Misi belum diatur.',
            'stats' => [
                'members' => \App\Models\Membership::count(),
                'books' => \App\Models\Book::count(),
                'journals' => \App\Models\Journal::count(),
               'teams' => \App\Models\Frontend\Team\Team::count(),
            ]
        ]
    ]);
});

Route::get('/books', function () {
    $books = \App\Models\Book::with(['writers', 'categories'])->latest()->get();
    
    return response()->json([
        'status' => 'success',
        'data' => $books
    ]);
});
Route::get('/journals', function () {
    $journals = \App\Models\Journal::with('keywords')->latest('journal_id')->get();
    
    return response()->json([
        'status' => 'success',
        'data' => $journals
    ]);
});
// Endpoint Publik untuk mengambil Daftar Member
Route::get('/members', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Membership::with('user')
        ->select('memberships.*')
        ->addSelect('users.first_name', 'users.last_name', 'users.img_path') 
        ->leftJoin('users', 'memberships.user_id', '=', 'users.user_id');
    $query->orderBy('memberships.created_at', 'desc');
    $memberships = $query->take(50)->get();

    return response()->json([
        'status' => 'success',
        'data' => $memberships
    ]);
});

Route::get('/guidelines', function () {
    $schemes = \App\Models\Frontend\AuthorGuideline\PublishingScheme::all();
    $steps = \App\Models\Frontend\AuthorGuideline\PublishingStep::orderBy('id', 'asc')->get();
    
    return response()->json([
        'status' => 'success',
        'data' => [
            'schemes' => $schemes,
            'steps' => $steps
        ]
    ]);
});

// Endpoint Publik untuk Layanan Jurnal
Route::get('/journal-services', function () {
    $aim_scope = \App\Models\Setting::where('key', 'journal_aim_scope_text')->first();
    $scopes = \App\Models\Frontend\JournalService\Scope::all();
    $services = \App\Models\Frontend\JournalService\Service::all();

    return response()->json([
        'status' => 'success',
        'data' => [
            'aim_scope' => $aim_scope->value ?? 'Deskripsi Aim & Scope belum diatur oleh Admin.',
            'scopes' => $scopes,
            'services' => $services
        ]
    ]);
});

// Endpoint Publik untuk Benefit Membership
Route::get('/membership-benefits', function () {
    $price = \App\Models\Setting::where('key', 'membership_price')->first();
    $price_desc = \App\Models\Setting::where('key', 'membership_price_description')->first();
    $benefits = \App\Models\Frontend\Membership\Benefit::all();
    $faqs = \App\Models\Frontend\Membership\Faq::latest()->get();

    return response()->json([
        'status' => 'success',
        'data' => [
            'price' => $price->value ?? 'Harga belum diatur',
            'price_description' => $price_desc->value ?? '',
            'benefits' => $benefits,
            'faqs' => $faqs
        ]
    ]);
});

// Endpoint Publik untuk Layanan HAKI
Route::get('/haki', function () {
    $intro_title = \App\Models\Setting::where('key', 'haki_intro_title')->first();
    $intro_desc = \App\Models\Setting::where('key', 'haki_intro_description')->first();
    
    // Jangan lupa sesuaikan path modelnya dengan foldermu
    $types = \App\Models\Frontend\Haki\HakiType::all();
    $packages = \App\Models\Frontend\Haki\HakiPackage::all();

    return response()->json([
        'status' => 'success',
        'data' => [
            'intro_title' => $intro_title->value ?? 'Layanan HAKI Terpadu',
            'intro_description' => $intro_desc->value ?? 'Lindungi karya dan inovasi Anda bersama Ritecs.',
            'types' => $types,
            'packages' => $packages
        ]
    ]);
});

// Endpoint Publik untuk Pusat Pelatihan
Route::get('/training-center', function () {
    $trainings = \App\Models\Frontend\Training\Training::all();
    $haki_services = \App\Models\Frontend\Training\HakiService::all();
    $haki_title = \App\Models\Setting::where('key', 'training_haki_title')->first();
    $haki_desc = \App\Models\Setting::where('key', 'training_haki_description')->first();

    return response()->json([
        'status' => 'success',
        'data' => [
            'trainings' => $trainings,
            'haki_services' => $haki_services,
            'haki_title' => $haki_title->value ?? 'Layanan Pendukung HAKI',
            'haki_description' => $haki_desc->value ?? 'Kami juga menyediakan bantuan pendaftaran HAKI untuk hasil pelatihan Anda.'
        ]
    ]);
});

Route::get('/tentang', function () {
    $carousel = \App\Models\Frontend\Home\Carousel::first();
    
    return response()->json([
        'status' => 'success',
        'data' => [
            'pre_title' => $carousel->pre_title ?? 'RITECS',
            'subtitle' => $carousel->subtitle   ?? 'Terdaftar pada Kementrian Hukum dan Hak Asasi Manusia',
            'vision' => \App\Models\Setting::where('key', 'page_vision_text')->first()->value ?? 'Visi belum diatur.',
            'mission' => \App\Models\Setting::where('key', 'page_mission_text')->first()->value ?? 'Misi belum diatur.',
        ]
    ]);
});

Route::get('/contact-info', function () {
    return response()->json([
        'status' => 'success',
        'data' => [
            'address' => \App\Models\Setting::where('key', 'contact_address')->first()->value ?? '',
            'email' => \App\Models\Setting::where('key', 'contact_email')->first()->value ?? '',
            'phone' => \App\Models\Setting::where('key', 'contact_phone')->first()->value ?? '',
            'site' => \App\Models\Setting::where('key', 'contact_site')->first()->value ?? '',
            'map_link' => \App\Models\Setting::where('key', 'contact_map_link')->first()->value ?? '',
        ]
    ]);
});


Route::post('/contact-send', function (\Illuminate\Http\Request $request) {
    $validatedData = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    
    $validatedData['status'] = 'pending';
    \App\Models\Comment::create($validatedData);
    
    return response()->json(['status' => 'success', 'message' => 'Pesan Anda telah berhasil terkirim!']);
});
Route::post('/books/{id}/visit', [BookController::class, 'incrementVisit']);
Route::post('/books/{id}/download', [BookController::class, 'incrementDownload']);