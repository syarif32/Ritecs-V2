<?php

namespace App\Http\Controllers\Admin\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Home\Carousel;
use App\Models\Frontend\Home\HomeFaq;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    
    public function index()
    {
        
        $carousels = Carousel::latest()->get();
        $home_faqs = HomeFaq::latest()->get();
        $faq_image = Setting::firstOrCreate(['key' => 'home_faq_image'], ['value' => 'assets/img/carousel-2.png']);

        // Kirim semua data ke view admin
        return view('backend.pages.home.index', [
            'title'     => 'Manage Home Page',
            'carousels' => $carousels,
            'home_faqs' => $home_faqs,
            'faq_image' => $faq_image->value,
        ]);
    }

    public function updateFaqImage(Request $request)
    {
        $request->validate([
            'faq_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('faq_image')) {
           
            $old_image = Setting::where('key', 'home_faq_image')->first();
            if ($old_image && $old_image->value) {
                \Storage::disk('')->delete($old_image->value);
            }
            
          
            $path = $request->file('faq_image')->store('home', 'public');

           
            Setting::updateOrCreate(
                ['key' => 'home_faq_image'],
                ['value' => $path]
            );
        }

        return redirect()->route('admin.page.home.index')->with('success', 'Gambar FAQ berhasil diperbarui!');
    }
}