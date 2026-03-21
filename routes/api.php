<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Models\MembershipCardSetting;

Route::prefix('auth')->group(function () {
    Route::post('/request-otp', [ApiAuthController::class, 'requestOtp']);
    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
    Route::post('/login', [ApiAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    
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
    // Mengambil data buku beserta relasi penulis dan kategori
    $books = \App\Models\Book::with(['writers', 'categories'])->latest()->get();
    
    return response()->json([
        'status' => 'success',
        'data' => $books
    ]);
});

// Endpoint Publik untuk mengambil Daftar Member
Route::get('/members', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Membership::with('user')
        ->select('memberships.*')
        ->addSelect('users.first_name', 'users.last_name', 'users.img_path') // Bawa foto profil sekalian!
        ->leftJoin('users', 'memberships.user_id', '=', 'users.user_id');

    // Kita urutkan dari member terbaru
    $query->orderBy('memberships.created_at', 'desc');

    // Ambil 50 data dulu agar Android tidak berat (bisa pakai pagination nanti)
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
    // Sesuaikan path model dengan struktur folder Laravel-mu
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
Route::post('/books/{id}/visit', [\App\Http\Controllers\Api\BookController::class, 'incrementVisit']);
Route::post('/books/{id}/download', [\App\Http\Controllers\Api\BookController::class, 'incrementDownload']);