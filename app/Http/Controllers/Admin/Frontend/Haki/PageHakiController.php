<?php

namespace App\Http\Controllers\Admin\Frontend\Haki;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Haki\HakiType;
use App\Models\Frontend\Haki\HakiPackage;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageHakiController extends Controller
{
    public function index()
    {
        return view('backend.pages.haki.index', [
            'title' => 'Manage HAKI Page',
            'haki_intro_title' => Setting::firstOrCreate(['key' => 'haki_intro_title'], ['value' => 'Tentang HAKI']),
            'haki_intro_subtitle' => Setting::firstOrCreate(['key' => 'haki_intro_subtitle'], ['value' => 'Pentingnya Hak Atas Kekayaan Intelektual']),
            'haki_intro_description' => Setting::firstOrCreate(['key' => 'haki_intro_description'], ['value' => 'Deskripsi default...']),
            'haki_types' => HakiType::latest()->get(),
            'haki_packages' => HakiPackage::latest()->get(),
            'icons' => config('icons.font_awesome'),
        ]);
    }

    public function update(Request $request)
    {
        $keys = ['haki_intro_title', 'haki_intro_subtitle', 'haki_intro_description'];
        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
        }
        return redirect()->route('admin.page.haki.index')->with('success', 'Konten intro HAKI berhasil diperbarui!');
    }
}