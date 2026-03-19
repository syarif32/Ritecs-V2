<?php

namespace App\Http\Controllers\Admin\Frontend\Training;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Training\HakiService;
use App\Models\Frontend\Training\Training;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageTrainingController extends Controller
{
    public function index()
    {
        return view('backend.pages.training.index', [
            'title' => 'Manage Training Center Page',
            'haki_title' => Setting::firstOrCreate(['key' => 'training_haki_title'], ['value' => 'Kekayaan Intelektual']),
            'haki_subtitle' => Setting::firstOrCreate(['key' => 'training_haki_subtitle'], ['value' => 'Lindungi Karya Anda dengan Layanan HAKI']),
            'haki_description' => Setting::firstOrCreate(['key' => 'training_haki_description'], ['value' => 'Deskripsi default untuk layanan HAKI...']),
            'haki_image' => Setting::firstOrCreate(['key' => 'training_haki_image']),
            'trainings' => Training::latest()->get(),
            'haki_services' => HakiService::latest()->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'training_haki_title' => 'required|string',
            'training_haki_subtitle' => 'required|string',
            'training_haki_description' => 'required|string',
            'training_haki_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $keys = ['training_haki_title', 'training_haki_subtitle', 'training_haki_description'];
        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
        }

        if ($request->hasFile('training_haki_image')) {
            $setting = Setting::firstOrCreate(['key' => 'training_haki_image']);
            if ($setting->value) {
                Storage::disk('public')->delete($setting->value);
            }
            $path = $request->file('training_haki_image')->store('training-haki', 'public');
            $setting->update(['value' => $path]);
        }
        
        return redirect()->route('admin.page.training.index')->with('success', 'Konten HAKI berhasil diperbarui!');
    }
}