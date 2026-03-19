<?php

namespace App\Http\Controllers\Admin\Frontend\VisionMission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

namespace App\Http\Controllers\Admin\Frontend\VisionMission;

use App\Http\Controllers\Controller;
use App\Models\Setting; 
use Illuminate\Http\Request;

class PageVisionMissionController extends Controller
{
    public function index()
    {
        // Mengambil atau membuat data Visi dan Misi dari tabel settings
        $vision = Setting::firstOrCreate(['key' => 'page_vision_text'], ['value' => '<h3>Visi</h3><p>Tulis teks visi di sini...</p>']);
        $mission = Setting::firstOrCreate(['key' => 'page_mission_text'], ['value' => '<h3>Misi</h3><p><i class="fa fa-check text-primary me-3"></i>Tulis poin misi pertama di sini...</p>']);
        
        return view('backend.pages.vision_mission.index', [
            'title' => 'Manage Vision & Mission Page',
            'vision' => $vision,
            'mission' => $mission,
        ]);
    }

    public function update(Request $request)
    {
        // Validasi bahwa input ada
        $request->validate([
            'vision_text' => 'required|string',
            'mission_text' => 'required|string',
        ]);

        // Update data Visi
        Setting::updateOrCreate(
            ['key' => 'page_vision_text'],
            ['value' => $request->input('vision_text')]
        );

        // Update data Misi
        Setting::updateOrCreate(
            ['key' => 'page_mission_text'],
            ['value' => $request->input('mission_text')]
        );

        return redirect()->route('admin.page.vision-mission.index')->with('success', 'Halaman Visi & Misi berhasil diperbarui!');
    }
}
