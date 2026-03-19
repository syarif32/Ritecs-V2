<?php

namespace App\Http\Controllers\Admin\Frontend\JournalService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Frontend\JournalService\Scope;
use App\Models\Frontend\JournalService\Service;

class PageJournalServiceController extends Controller
{
    public function index()
    {
        $aim_scope = Setting::firstOrCreate(['key' => 'journal_aim_scope_text'], ['value' => 'Isi deskripsi tujuan & ruang lingkup di sini.']);
        $scopes = Scope::latest()->get();
        $services = Service::latest()->get();

        return view('backend.pages.layanan-jurnal.index', [
            'title' => 'Manage Journal Service Page',
            'aim_scope' => $aim_scope,
            'scopes' => $scopes,
            'services' => $services
        ]);
    }

    public function update(Request $request)
    {
        $setting = Setting::where('key', 'journal_aim_scope_text')->first();
        $setting->value = $request->input('journal_aim_scope_text');
        $setting->save();

        return redirect()->route('admin.page.journal-service.index')->with('success', 'Data berhasil diperbarui!');
    }
}