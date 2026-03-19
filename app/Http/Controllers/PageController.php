<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Journal;
use App\Models\Keyword;
use App\Models\Awarding;
use App\Models\Book;
use App\Models\Frontend\Membership\Benefit;
use App\Models\Frontend\Membership\Faq;
use App\Models\Setting;
use App\Models\Frontend\JournalService\Scope;
use App\Models\Frontend\JournalService\Service;
use App\Models\Frontend\AuthorGuideline\BookType;
use App\Models\Frontend\AuthorGuideline\PublishingScheme;
use App\Models\Frontend\AuthorGuideline\PublishingStep;
use App\Models\Frontend\Home\Carousel;
use App\Models\Frontend\Home\HomeFaq;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Frontend\Training\Training;
use App\Models\Frontend\Training\HakiService;
use App\Models\Frontend\Haki\HakiType;
use App\Models\Frontend\Haki\HakiPackage;
use App\Models\Frontend\Team\Team; 
use App\Models\Membership;
use Illuminate\Support\Facades\Session;
class PageController extends Controller
{
    public function home()
    {
        $journals = Journal::with('keywords')->latest()->take(3)->get();
        $carousels = Carousel::all();
        $home_faqs = HomeFaq::all();
        $faq_image = Setting::where('key', 'home_faq_image')->first();
        $vision = Setting::where('key', 'page_vision_text')->first();
        $mission = Setting::where('key', 'page_mission_text')->first();
        $teams = Team::all();
        $membershipCount = Membership::count();
        $teamCount = Team::count();
        $bookCount = Book::count();
        $journalCount = Journal::count();
        return view('pages.home', [
            'title' => 'Home',
            'carousels' => $carousels,
            'journals' => $journals,
            'vision' => $vision->value ?? 'Visi belum diatur dari admin.',
            'mission' => $mission->value ?? 'Misi belum diatur dari admin.',
            'home_faqs' => $home_faqs,
            'faq_image' => $faq_image->value ?? 'assets/img/carousel-2.png',
            'teams' => $teams,
            'membershipCount' => $membershipCount,
            'teamCount' => $teamCount,
            'bookCount' => $bookCount,
            'journalCount' => $journalCount,
        ]);
    }

    public function about()
    {
        $vision = Setting::where('key', 'page_vision_text')->first();
        $mission = Setting::where('key', 'page_mission_text')->first();
        $home_faqs = HomeFaq::all();
        $faq_image = Setting::where('key', 'home_faq_image')->first();
        $teams = Team::all();
         $membershipCount = Membership::count();
        $teamCount = Team::count();
        $bookCount = Book::count();
        $journalCount = Journal::count();
        return view('pages.about', [
            'title' => 'About Us',
            'vision' => $vision->value ?? 'Visi belum tersedia.',
            'mission' => $mission->value ?? 'Misi belum terdiasa.',
            'home_faqs' => $home_faqs,
            'faq_image' => $faq_image->value ?? 'assets/img/carousel-2.png',
            'teams' => $teams,
            'membershipCount' => $membershipCount,
            'teamCount' => $teamCount,
            'bookCount' => $bookCount,
            'journalCount' => $journalCount,
        ]);
    }

    // public function contact()
    // {
    //     return view('pages.contact', ['title' => 'Contact']);
    // }

    public function buku()
    {
        $books = Book::with([
            'writers' => function($query) {
                $query->orderBy('book_writer.order', 'asc');
            }, 
            'categories'
        ])->latest()->get();

        return view('pages.buku', [
            'title' => 'Buku',
            'books' => $books
        ]);
    }
    // public function detailBuku($id)
    // {
    //     $book = Book::with(['writers', 'categories'])->findOrFail($id);

    //     return view('pages.detail-buku', [
    //         'title' => $book->title,
    //         'book' => $book
    //     ]);
    // }
    // public function service()
    // {
    //     return view('pages.service', ['title' => 'Service']);
    // }
    public function detailBuku($id)
    {
        $book = Book::with([
            'writers' => function($query) {
                $query->orderBy('book_writer.order', 'asc');
            }, 
            'categories'
        ])->findOrFail($id);
        
        $sessionKey = 'book_visited_' . $id;
        if (!Session::has($sessionKey)) {
            $book->increment('visitor_count');
            Session::put($sessionKey, true);
        }

        return view('pages.detail-buku', [
            'title' => $book->title,
            'book' => $book
        ]);
    }

    public function downloadBuku($id)
    {
        $book = Book::findOrFail($id);
        $book->increment('download_count');
        return redirect(asset($book->ebook_path));
    }
    public function service()
    {
        return view('pages.service', ['title' => 'Service']);
    }

public function trainingCenter()
{
    return view('pages.training-center', [
        'title' => 'Pusat Pelatihan',
        'trainings' => Training::all(),
        'haki_services' => HakiService::all(),
        'haki_title' => Setting::where('key', 'training_haki_title')->first(),
        'haki_subtitle' => Setting::where('key', 'training_haki_subtitle')->first(),
        'haki_description' => Setting::where('key', 'training_haki_description')->first(),
        'haki_image' => Setting::where('key', 'training_haki_image')->first(),
    ]);
}


    public function petunjukPenulis()
    {
        return view('pages.petunjuk-penulis', [
            'title' => 'Petunjuk Penulis',
            'book_types_title' => Setting::where('key', 'guideline_bt_title')->first(),
            'book_types_subtitle' => Setting::where('key', 'guideline_bt_subtitle')->first(),
            'schemes_title' => Setting::where('key', 'guideline_ps_title')->first(),
            'schemes_subtitle' => Setting::where('key', 'guideline_ps_subtitle')->first(),
            'steps_title' => Setting::where('key', 'guideline_st_title')->first(),
            'steps_subtitle' => Setting::where('key', 'guideline_st_subtitle')->first(),
            'book_types' => BookType::all(),
            'publishing_schemes' => PublishingScheme::all(),
            'publishing_steps' => PublishingStep::orderBy('id', 'asc')->get(),
        ]);
    }
    // public function LayananJournal()
    // {
    //     return view('pages.ircs-journal', ['title' => 'Layanan Jurnal']);
    // }
    public function LayananJournal()
    {
        $aim_scope = Setting::where('key', 'journal_aim_scope_text')->first();
        $scopes = Scope::all();
        $services = Service::all();

        return view('pages.ircs-journal', [
            'title' => 'Layanan Jurnal',
            'aim_scope_text' => $aim_scope->value ?? 'Konten belum diatur.',
            'scopes' => $scopes,
            'services' => $services,
        ]);
    }
    public function membership()
    {
        $price = Setting::where('key', 'membership_price')->first();
        $price_description = Setting::where('key', 'membership_price_description')->first();

        return view('pages.membership', [
            
            'title' => 'Membership',
            'price' => $price->value ?? 'N/A',
            'price_description' => $price_description->value ?? '',
            'benefits' => Benefit::all(),
            'featured_benefits' => Benefit::where('is_featured', true)->get(),
            'faqs' => Faq::latest()->get(),
        ]);
    }


    public function journal()
    {

        $keywords = Keyword::orderBy('name')->get();
        $query = Journal::query()->with('keywords');
        if (request()->has('keyword') && request('keyword') != '') {
            $query->whereHas('keywords', function ($q) {
                $q->where('name', request('keyword'));
            });
        }
        if (request()->has('search') && request('search') != '') {
            $searchTerm = request('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('keywords', function ($keywordQuery) use ($searchTerm) {
                        $keywordQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }
        $sortBy = request('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
                break;
        }
        $journals = $query->paginate(9)->appends(request()->query());

        return view('pages.journal', [
            'title' => 'Jurnal',
            'journals' => $journals,
            'keywords' => $keywords
        ]);
    }

    public function detailjurnal()
    {
        return view('pages.detail-jurnal', ['title' => 'Detail Jurnal']);
    }

    public function awarding(Request $request)
    {

        $keywords = Keyword::orderBy('name')->get();
        $query = Awarding::query()->with('keywords');

        if ($request->has('keyword') && $request->keyword != '') {
            $query->whereHas('keywords', function ($q) use ($request) {
                $q->where('name', $request->keyword);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%$searchTerm%")
                ->orWhereHas('keywords', function ($keywordQuery) use ($searchTerm) {
                    $keywordQuery->where('name', 'like', "%$searchTerm%");
                });
            });
        }

        $awardings = $query->orderBy('awarding_id', 'asc')->get();

        // Awarding yang ditampilkan paling atas (default → pertama)
        $selected = null;
        if ($request->has('id')) {
            $selected = Awarding::with('keywords')->find($request->id);
        }
        if (!$selected && $awardings->count()) {
            $selected = $awardings->first();
        }

        $keywords = Keyword::orderBy('name')->get();
        $query = Journal::query()->with('keywords');
        if (request()->has('keyword') && request('keyword') != '') {
            $query->whereHas('keywords', function ($q) {
                $q->where('name', request('keyword'));
            });
        }
        if (request()->has('search') && request('search') != '') {
            $searchTerm = request('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('keywords', function ($keywordQuery) use ($searchTerm) {
                        $keywordQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }
        $sortBy = request('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
                break;
        }
        $journals = $query->paginate(9)->appends(request()->query());

        return view('pages.awarding', [
            'title' => 'Awardings',
            'journals' => $journals,
            'keywords' => $keywords,
            'awardings' => $awardings,
            'selected'  => $selected,
            'keywords'  => $keywords
        ]);
    }

    public function awardingShow($id)
    {
        $award = Awarding::with('keywords')->findOrFail($id);

        return response()->json($award);
    }
   


public function haki()
{
    return view('pages.haki', [
        'title' => 'Layanan HAKI',
        'haki_intro_title' => Setting::where('key', 'haki_intro_title')->first(),
        'haki_intro_subtitle' => Setting::where('key', 'haki_intro_subtitle')->first(),
        'haki_intro_description' => Setting::where('key', 'haki_intro_description')->first(),
        'haki_types' => HakiType::all(),
        'haki_packages' => HakiPackage::all(),
    ]);
}

     
// public function members(Request $request)
// {
//     $query = Membership::with('user')
//                 ->whereHas('user')
//                 ->join('users', 'memberships.user_id', '=', 'users.user_id')
               
//                 ->select('memberships.*');

    
//     if ($request->filled('search')) {
//         $search = $request->search;
//         $query->where(function ($q) use ($search) {
//             $q->where('users.first_name', 'like', "%{$search}%")
//               ->orWhere('users.last_name', 'like', "%{$search}%")
//               ->orWhere('memberships.member_number', 'like', "%{$search}%");
//         });
//     }

    
//     if ($request->filled('status')) {
//             if ($request->status === 'active') {

//                 $query->where('memberships.status', 1);
//             } elseif ($request->status === 'expired') {

//                 $query->where('memberships.status', 0);
//             }
//         }

    
//     $sortOrder = $request->input('sort', 'name_asc');
//     switch ($sortOrder) {
//         case 'newest':
//             $query->orderBy('memberships.created_at', 'desc');
//             break;
//         case 'oldest':
//             $query->orderBy('memberships.created_at', 'asc');
//             break;
//         case 'name_desc':
           
//             $query->orderByRaw("CONCAT(users.first_name, ' ', users.last_name) DESC");
//             break;
//         default: 
//             $query->orderByRaw("CONCAT(users.first_name, ' ', users.last_name) ASC");
//             break;
//     }

//     $memberships = $query->paginate(12)->appends($request->query());

//     return view('pages.membership.index', [
//         'title' => 'Members',
//         'memberships' => $memberships
//     ]);
// }
public function members(Request $request)
{
    $query = \App\Models\Membership::with('user')
        ->select('memberships.*') 
        ->addSelect('users.first_name', 'users.last_name') 
        ->leftJoin('users', 'memberships.user_id', '=', 'users.user_id');

    // --- 1. SEARCH LOGIC ---
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('users.first_name', 'like', "%{$search}%")
              ->orWhere('users.last_name', 'like', "%{$search}%")
              // Perbaikan nama kolom pencarian untuk Guest
              ->orWhere('memberships.guest_first_name', 'like', "%{$search}%")
              ->orWhere('memberships.guest_last_name', 'like', "%{$search}%")
              ->orWhere('memberships.member_number', 'like', "%{$search}%");
        });
    }

    // --- 2. FILTER STATUS ---
    if ($request->filled('status')) {
        if ($request->status === 'active') {
            $query->where('memberships.status', 1);
        } elseif ($request->status === 'expired') {
            $query->where('memberships.status', 0);
        }
    }

    // --- 3. SORTING LOGIC ---
    $sortOrder = $request->input('sort', 'name_asc');
    
    // Perbaikan logika pengurutan nama
    $nameSortLogic = "COALESCE(
        CONCAT(users.first_name, ' ', users.last_name), 
        CONCAT(memberships.guest_first_name, ' ', memberships.guest_last_name)
    )";

    switch ($sortOrder) {
        case 'newest':
            $query->orderBy('memberships.created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('memberships.created_at', 'asc');
            break;
        case 'name_desc':
            $query->orderByRaw("$nameSortLogic DESC");
            break;
        default: // name_asc
            $query->orderByRaw("$nameSortLogic ASC");
            break;
    }

    $memberships = $query->paginate(12)->appends($request->query());

    return view('pages.membership.index', [
        'title' => 'Members',
        'memberships' => $memberships
    ]);
}
}



