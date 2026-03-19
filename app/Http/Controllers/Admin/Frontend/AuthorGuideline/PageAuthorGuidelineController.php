<?php

namespace App\Http\Controllers\Admin\Frontend\AuthorGuideline;
use App\Http\Controllers\Controller;
use App\Models\Frontend\AuthorGuideline\BookType;
use App\Models\Frontend\AuthorGuideline\PublishingScheme;
use App\Models\Frontend\AuthorGuideline\PublishingStep;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageAuthorGuidelineController extends Controller
{
    public function index()
    {
        return view('backend.pages.author_guideline.index', [
            'title' => 'Manage Author Guidelines',
            'book_types_title' => Setting::firstOrCreate(['key' => 'guideline_bt_title'], ['value' => 'Menerbitkan Buku Bersama Ritecs']),
            'book_types_subtitle' => Setting::firstOrCreate(['key' => 'guideline_bt_subtitle'], ['value' => 'Kami menerima beragam jenis naskah...']),
            'schemes_title' => Setting::firstOrCreate(['key' => 'guideline_ps_title'], ['value' => 'Skema Penerbitan Buku']),
            'schemes_subtitle' => Setting::firstOrCreate(['key' => 'guideline_ps_subtitle'], ['value' => 'Pilih skema penerbitan yang paling sesuai...']),
            'steps_title' => Setting::firstOrCreate(['key' => 'guideline_st_title'], ['value' => 'Prosedur Penerbitan Buku']),
            'steps_subtitle' => Setting::firstOrCreate(['key' => 'guideline_st_subtitle'], ['value' => 'Ikuti langkah-langkah berikut...']),
            'book_types' => BookType::latest()->get(),
            'publishing_schemes' => PublishingScheme::latest()->get(),
            'publishing_steps' => PublishingStep::latest()->get(),
        ]);
    }

    public function update(Request $request)
    {
        $keys = ['guideline_bt_title', 'guideline_bt_subtitle', 'guideline_ps_title', 'guideline_ps_subtitle', 'guideline_st_title', 'guideline_st_subtitle'];
        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
        }
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Judul & Subjudul berhasil diperbarui!');
    }
}