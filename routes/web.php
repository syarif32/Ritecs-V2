<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\PublishedJournalsController;
use App\Http\Controllers\AwardingController;
use App\Http\Controllers\PublishedBooksController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\Admin\Frontend\JournalService\PageJournalServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Frontend\JournalService\ScopeController;
use App\Http\Controllers\Admin\Frontend\JournalService\ServiceController;
use App\Http\Controllers\Admin\Frontend\VisionMission\PageVisionMissionController;
use App\Http\Controllers\Admin\Frontend\Membership\PageMembershipController;
use App\Http\Controllers\Admin\Frontend\Membership\BenefitController;
use App\Http\Controllers\Admin\Frontend\Membership\FaqController;   
use App\Http\Controllers\Admin\Frontend\AuthorGuideline\PageAuthorGuidelineController;
use App\Http\Controllers\Admin\Frontend\AuthorGuideline\BookTypeController;
use App\Http\Controllers\Admin\Frontend\AuthorGuideline\PublishingSchemeController;
use App\Http\Controllers\Admin\Frontend\AuthorGuideline\PublishingStepController;
use App\Http\Controllers\Admin\Frontend\Home\CarouselController;
use App\Http\Controllers\Admin\Frontend\Home\HomeFaqController;
use App\Http\Controllers\Admin\Frontend\Home\PageHomeController;
use App\Http\Controllers\Admin\Frontend\PageContactController;
use App\Http\Controllers\Admin\Frontend\Footer\PageFooterController;
use App\Http\Controllers\Admin\Frontend\Footer\FooterGalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipsTransactionController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Admin\Frontend\Training\PageTrainingController;
use App\Http\Controllers\Admin\Frontend\Training\TrainingController;
use App\Http\Controllers\Admin\Frontend\Training\HakiServiceController;
use App\Http\Controllers\Admin\Frontend\Haki\PageHakiController;
use App\Http\Controllers\Admin\Frontend\Haki\HakiTypeController;
use App\Http\Controllers\Admin\Frontend\Haki\HakiPackageController;
use App\Http\Controllers\Admin\Maintenance\MaintenanceController;
use App\Http\Controllers\Admin\Frontend\Team\PageTeamController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\ManageUserMembershipController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Auth\OtpVerificationController;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserManagement\UserManagementController;
use App\Http\Controllers\Admin\Comment\CommentController;
use App\Http\Controllers\Admin\ActivationRequest\ActivationRequestController;
use App\Http\Controllers\MembershipCardController;
// use App\Http\Controllers\Api\Auth\ApiAuthController;

// Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
//     Route::post('/login', [ApiAuthController::class, 'login']);
//     Route::post('/request-otp', [ApiAuthController::class, 'requestOtp']);
//     Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
// });

// auth google
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/login', [AuthController::class, 'showLoginMessage'])->name('login');

// Rute Autentikasi
Route::post('/register', [AuthController::class, 'register'])->name('register');
// otp

Route::get('otp/verify/{userId}', [OtpVerificationController::class, 'showVerificationForm'])
    ->name('otp.verify.show')->middleware('signed');
Route::post('otp/verify', [OtpVerificationController::class, 'verify'])->name('otp.verify.form');
Route::get('otp/resend/{userId}', [OtpVerificationController::class, 'resend'])->name('otp.resend');
Route::post('/otp/request-manual', [OtpVerificationController::class, 'requestManual'])->name('otp.request.manual');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logOut', [AuthController::class, 'logout'])->name('logout.get')->middleware('auth');

//  forgot pw 
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');


Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/access-management', [UserManagementController::class, 'index'])
        ->name('usersmanagement.index'); 

    // 2. Halaman History Log
    
    Route::get('/access-management/history', [UserManagementController::class, 'logHistory'])
        ->name('users.history');

    // 3. pecat dan angkat admin
    Route::patch('/access-management/{id}/promote', [UserManagementController::class, 'promoteToAdmin'])
        ->name('users.promote');
        
    Route::patch('/access-management/{id}/demote', [UserManagementController::class, 'demoteToUser'])
        ->name('users.demote');

    // Published Journals
    Route::get('/published-journals', [PublishedJournalsController::class, 'journalData'])->name('published-journals');

    // View, Update & Delete Journal - (note: edit memakai {id} dan update POST ke {id})
    Route::get('/edit-journal/{id}', [PublishedJournalsController::class, 'journalEdit'])->name('edit-journals');
    Route::post('/update-journal/{id}', [PublishedJournalsController::class, 'journalUpdate'])->name('update-journals');
    Route::get('/delete-journal/{id}', [PublishedJournalsController::class, 'journalDelete'])->name('delete-journals');
    Route::get('/add-journal', [PublishedJournalsController::class, 'journalCreate'])->name('create-journals');
    Route::post('/store-journal', [PublishedJournalsController::class, 'journalStore'])->name('store-journals');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    
    Route::get('/published-awardings', [AwardingController::class, 'index'])->name('awardings.index');
    Route::get('/add-awardings', [AwardingController::class, 'create'])->name('awardings.create');
    Route::post('/store-awardings', [AwardingController::class, 'store'])->name('awardings.store');
    Route::get('/edit-awardings/{id}', [AwardingController::class, 'edit'])->name('awardings.edit');
    Route::put('/update-awardings/{id}', [AwardingController::class, 'update'])->name('awardings.update');
    Route::get('/delete-awardings/{id}', [AwardingController::class, 'destroy'])->name('awardings.destroy');


    Route::get('/published-books', [PublishedBooksController::class, 'bookData'])->name('published-books');
    Route::get('/add-book', [PublishedBooksController::class, 'bookCreate'])->name('create-books');
    Route::post('/store-book', [PublishedBooksController::class, 'bookStore'])->name('store-books');
    Route::get('/edit-book/{id}', [PublishedBooksController::class, 'bookEdit'])->name('edit-books');
    Route::post('/update-book/{id}', [PublishedBooksController::class, 'bookUpdate'])->name('update-books');
    Route::get('/delete-book/{id}', [PublishedBooksController::class, 'bookDelete'])->name('delete-books');
    
    // Keywords Journal
    Route::get('/keywords', [KeywordController::class, 'index'])->name('keywords');
    Route::get('/keywords/create', [KeywordController::class, 'create'])->name('keywords.create');
    Route::post('/keywords/store', [KeywordController::class, 'store'])->name('keywords.store');
    Route::get('/keywords/edit/{id}', [KeywordController::class, 'edit'])->name('keywords.edit');
    Route::post('/keywords/update/{id}', [KeywordController::class, 'update'])->name('keywords.update');
    Route::get('/keywords/delete/{id}', [KeywordController::class, 'destroy'])->name('keywords.delete');

    // Categories Book
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

    // Writers Book
    Route::get('/writers', [WriterController::class, 'index'])->name('writers');
    Route::get('/writers/create', [WriterController::class, 'create'])->name('writers.create');
    Route::post('/writers/store', [WriterController::class, 'store'])->name('writers.store');
    Route::get('/writers/edit/{id}', [WriterController::class, 'edit'])->name('writers.edit');
    Route::put('/writers/update/{id}', [WriterController::class, 'update'])->name('writers.update');
    Route::get('/writers/delete/{id}', [WriterController::class, 'destroy'])->name('writers.delete');
    Route::post('/admin/writers/ajax-store', [WriterController::class, 'ajaxStore'])->name('writers.ajax-store');


    Route::get('memberships', [MembershipsTransactionController::class,'index'])->name('memberships');
    Route::get('memberships/{id}/edit', [MembershipsTransactionController::class,'edit'])->name('memberships.edit');
    Route::post('memberships/{id}/update', [MembershipsTransactionController::class,'update'])->name('memberships.update');
    Route::get('memberships/{id}/delete', [MembershipsTransactionController::class,'delete'])->name('memberships.delete');
    Route::get('memberships/restore/{id}', [MembershipsTransactionController::class, 'restore'])->name('memberships.restore');
    Route::get('memberships/trashed', [MembershipsTransactionController::class, 'trashed'])->name('memberships.trashed');
    Route::get('/memberships/extend/{id}', [MembershipsTransactionController::class, 'extend'])->name('memberships.extend');

    // Manage Users
    Route::get('/users', [UserManageController::class, 'index'])->name('users.index');
    Route::get('/nonactiveusers', [UserManageController::class, 'nonactiveusers'])->name('users.nonactiveusers');
    Route::get('/users/create', [UserManageController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserManageController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserManageController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserManageController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserManageController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/restore/{id}', [UserManageController::class, 'restore'])->name('users.restore');
    Route::post('/users/{id}/make-member', [App\Http\Controllers\UserManageController::class, 'makeMember'])
    ->name('users.makeMember');
    // Route::get('/users/search', [App\Http\Controllers\UserManageController::class, 'search'])->name('users.search');
    
    
    // CARD SETTING
    Route::get('/membership-card-settings', [MembershipCardController::class, 'cardSettings'])
        ->name('membership-card-settings');
    Route::put('/membership-card-settings', [MembershipCardController::class, 'updateCardSettings'])
        ->name('membership-card-settings.update');
    Route::post('/membership-card-preview', [MembershipCardController::class, 'generatePreview'])
        ->name('membership-card-preview');
        
    // CARD FONT SETTING
    Route::post('/membership-card-fonts/upload', [MembershipCardController::class, 'uploadFont'])
        ->name('membership-card-fonts.upload');
    Route::post('/membership-card-fonts/delete', [MembershipCardController::class, 'deleteFont'])
        ->name('membership-card-fonts.delete');



    Route::get('manageUserMemberships/', [ManageUserMembershipController::class, 'index'])->name('manageUserMemberships.index');
    Route::get('manageUserMemberships/create', [ManageUserMembershipController::class, 'create'])->name('manageUserMemberships.create');
    Route::post('manageUserMemberships/store', [ManageUserMembershipController::class, 'store'])->name('manageUserMemberships.store');
    Route::get('manageUserMemberships/edit/{id}', [ManageUserMembershipController::class, 'edit'])->name('manageUserMemberships.edit');
    Route::post('manageUserMemberships/update/{id}', [ManageUserMembershipController::class, 'update'])->name('manageUserMemberships.update');
    Route::get('manageUserMemberships/destroy/{id}', [ManageUserMembershipController::class, 'destroy'])->name('manageUserMemberships.destroy');
    Route::get('manageUserMemberships/restore/{id}', [ManageUserMembershipController::class, 'restore'])->name('manageUserMemberships.restore');
    Route::get('manageUserMemberships/force-delete/{id}', [ManageUserMembershipController::class, 'forceDelete'])->name('manageUserMemberships.forceDelete');
    
    Route::get('manageUserMemberships/get-user-by-email', function (\Illuminate\Http\Request $r) {
    return \App\Models\User::where('email', $r->email)->first();
    })->name('getUserByEmail');

    
    
        Route::resource('banks', BankController::class);

        // Kelola Halaman FE
        Route::prefix('page')->name('page.')->group(function() {
        // home
        Route::get('/home', [PageHomeController::class, 'index'])->name('home.index');
        Route::post('/home/faq-image', [PageHomeController::class, 'updateFaqImage'])->name('home.updateFaqImage');
    
        //    layanan jurnal
        Route::get('/journal-service', [PageJournalServiceController::class, 'index'])->name('journal-service.index');
        Route::post('/journal-service/update', [PageJournalServiceController::class, 'update'])->name('journal-service.update');
        // visi misi
        Route::get('/vision-mission', [PageVisionMissionController::class, 'index'])->name('vision-mission.index');
        Route::post('/vision-mission/update', [PageVisionMissionController::class, 'update'])->name('vision-mission.update');
        // membership
        Route::get('/membership', [PageMembershipController::class, 'index'])->name('membership.index');
        Route::post('/membership/price', [PageMembershipController::class, 'updatePrice'])->name('membership.updatePrice');
        // petunjuk penulis / layanan buku
        Route::get('/author-guideline', [PageAuthorGuidelineController::class, 'index'])->name('author-guideline.index');
        Route::post('/author-guideline/update', [PageAuthorGuidelineController::class, 'update'])->name('author-guideline.update');
    // training center
    Route::get('/training', [PageTrainingController::class, 'index'])->name('training.index');
        Route::post('/training/update', [PageTrainingController::class, 'update'])->name('training.update');
        // haki
        Route::get('/haki', [PageHakiController::class, 'index'])->name('haki.index');
        Route::post('/haki/update', [PageHakiController::class, 'update'])->name('haki.update');
    
        // contact
        Route::get('/contact', [PageContactController::class, 'index'])->name('contact.index');
        Route::post('/contact/update', [PageContactController::class, 'update'])->name('contact.update');
        // footer
        Route::get('/footer', [PageFooterController::class, 'index'])->name('footer.index');
        Route::post('/footer/update', [PageFooterController::class, 'updateSettings'])->name('footer.updateSettings');
        
         Route::prefix('team')->name('team.')->group(function () {
            Route::get('/', [PageTeamController::class, 'index'])->name('index');
            Route::post('/update-settings', [PageTeamController::class, 'updateSettings'])->name('updateSettings');
            Route::post('/store', [PageTeamController::class, 'storeTeam'])->name('store');
            Route::put('/update/{team}', [PageTeamController::class, 'updateTeam'])->name('update');
            Route::delete('/destroy/{team}', [PageTeamController::class, 'destroyTeam'])->name('destroy');
        });
    

    });
  Route::get('/maintenance', [AdminPageController::class, 'maintenance'])->name('maintenance.index');
    Route::post('/maintenance/clear/{type}', [MaintenanceController::class, 'clearCache'])->name('maintenance.clear');
    Route::post('/maintenance/clear-logs', [MaintenanceController::class, 'clearLogs'])->name('maintenance.clearLogs');
    // ---  (Maintenance Area) ---
// Route::middleware(function ($request, $next) {
//     // Cek Email Hardcode (Hanya admin@ritecs.com yang boleh masuk)
//     if ($request->user()->email !== 'admin@ritecs.com') {
//         abort(403, 'AKSES DITOLAK: Fitur Maintenance hanya untuk Pemilik Sistem (Super Admin).');
//     }
//     return $next($request);
// })->group(function () {

   
//     Route::get('/maintenance', [AdminPageController::class, 'maintenance'])->name('maintenance.index');
    
//     Route::post('/maintenance/clear/{type}', [MaintenanceController::class, 'clearCache'])->name('maintenance.clear');
    
//     Route::post('/maintenance/clear-logs', [MaintenanceController::class, 'clearLogs'])->name('maintenance.clearLogs');

// });
    // komen
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    
    
    Route::resource('comments', CommentController::class);
    
     
Route::get('content-history', [App\Http\Controllers\ContentLogController::class, 'index'])->name('content-history');
    Route::patch('/comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');

    Route::resource('carousels', CarouselController::class);
    Route::resource('home-faqs', HomeFaqController::class)->except(['index', 'show']);
    Route::resource('scopes', ScopeController::class)->except(['index', 'show']);
    Route::resource('services', ServiceController::class)->except(['index', 'show']);
    Route::resource('benefits', BenefitController::class)->except(['index', 'show']);
    Route::resource('faqs', FaqController::class)->except(['index', 'show']);
    Route::resource('book-types', BookTypeController::class)->except(['index', 'show']);
    Route::resource('publishing-schemes', PublishingSchemeController::class)->except(['index', 'show']);
    Route::resource('publishing-steps', PublishingStepController::class)->except(['index', 'show']);
    Route::resource('trainings', TrainingController::class)->except(['index', 'show']);
    Route::resource('haki-services', HakiServiceController::class)->except(['index', 'show']); 
     Route::resource('haki-types', HakiTypeController::class)->except(['index', 'show']);
    Route::resource('haki-packages', HakiPackageController::class)->except(['index', 'show']);

    Route::resource('footer-galleries', FooterGalleryController::class)->except(['index', 'show']);
    

    
     Route::controller(ActivationRequestController::class)->group(function () {
       
        Route::get('/activation-requests', 'index')->name('activation.index'); 
        
        Route::put('/activation-requests/{id}/approve', 'approve')->name('activation.approve');
        Route::put('/activation-requests/{id}/reject', 'reject')->name('activation.reject');
    });



});



Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/member', [MembershipController::class, 'index'])->name('member');
    Route::post('/member/submit', [MembershipController::class, 'submitTransaction'])->name('member.submit');
    Route::get('/membership/{id}/card', [MembershipController::class, 'viewCard'])->name('membership.card.view');    

    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'update'])->name('settings.update'); 
    Route::put('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::get('/ktp/delete', [ProfileController::class, 'deleteKtp'])->name('ktp.delete');
    
    Route::get('/membership/card/{id}/download', [MembershipController::class, 'downloadCard'])
        ->name('membership.card.download');

});

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/buku', [PageController::class, 'buku'])->name('buku');
Route::get('/buku/{id}', [PageController::class, 'detailBuku'])->name('buku.detail');
Route::get('/buku/download/{id}', [PageController::class, 'downloadBuku'])->name('buku.download');
Route::get('/service', [PageController::class, 'service'])->name('service');
Route::get('/detail-buku', [PageController::class, 'detailBuku'])->name('detail-buku');
Route::get('/petunjuk-penulis', [PageController::class, 'petunjukPenulis'])->name('petunjuk-penulis');
// Route::get('/layanan-journal', [PageController::class, 'ircsJournal'])->name('layanan-journal');
// Route::get('/ircs-journal', [PageController::class, 'ircsJournal'])->name('ircs-journal');
Route::get('/layanan-journal', [PageController::class, 'LayananJournal'])
    ->name('layanan-journal');
Route::get('/membership', [PageController::class, 'membership'])->name('membership');

Route::get('/awardings', [PageController::class, 'awarding'])->name('awardings.index');
// Ajax detail awarding
Route::get('/awardings/{id}', [PageController::class, 'awardingShow'])->name('awardings.show');


Route::get('/journal', [PageController::class, 'journal'])->name('journal');
Route::get('/detail-jurnal', [PageController::class, 'detailjurnal'])->name('detail-jurnal');
Route::get('/training-center', [PageController::class, 'trainingCenter'])->name('training-center');
Route::get('/layanan/haki', [PageController::class, 'haki'])->name('layanan-haki');
Route::get('/members', [PageController::class, 'members'])->name('membership.index');

// Route contact get
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
// post
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');



// Route::get('/emergency-clear', function () {
//     \Illuminate\Support\Facades\Artisan::call('optimize:clear');
//     \Illuminate\Support\Facades\Artisan::call('config:clear');
//     \Illuminate\Support\Facades\Artisan::call('route:clear');
//     \Illuminate\Support\Facades\Artisan::call('view:clear');
//     \Illuminate\Support\Facades\Artisan::call('cache:clear');

//     return 'Semua cache berhasil dibersihkan!';
// });










// // chatbot routes
Route::get('/chatbot', [ChatbotController::class, 'showChat'])->name('chatbot.show');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
use Gemini\Laravel\Facades\Gemini; // <-- Pastikan ini ada di atas file

Route::get('/test-gemini', function () {
    try {
        // Kita hanya perlu memanggil metode sederhana untuk tes,
        // tidak perlu mengirim chat. Ini untuk membuktikan class-nya bisa dimuat.
        $result = Gemini::models()->list(); 

        return '✅ SUKSES: Paket Gemini berhasil dimuat oleh Laravel!';

    } catch (\Throwable $e) {
        // Jika terjadi error, kita akan menampilkannya langsung di browser.
        // Ini akan memberikan pesan error yang lebih jelas.
        return '❌ GAGAL: Terjadi error. Pesan: <pre>' . $e->getMessage() . '</pre>';
    }
});