<?php


namespace App\Http\Controllers\Admin\Frontend\Footer;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Footer\FooterGallery;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageFooterController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'contact_address', 'contact_email', 'contact_phone', 
            'footer_instagram_title', 'social_facebook', 'social_twitter', 
            'social_instagram', 'social_linkedin'
        ])->pluck('value', 'key');

        $footer_galleries = FooterGallery::latest()->get();

        return view('backend.pages.footer.index', [
            'title' => 'Manage Footer',
            'settings' => $settings,
            'footer_galleries' => $footer_galleries,
        ]);
    }

    public function updateSettings(Request $request)
    {
        $keys = [
            'contact_address', 'contact_email', 'contact_phone', 
            'footer_instagram_title', 'social_facebook', 'social_twitter', 
            'social_instagram', 'social_linkedin'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        return redirect()->route('admin.page.footer.index')->with('success', 'Pengaturan footer berhasil diperbarui!');
    }
}