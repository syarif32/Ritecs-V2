<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageContactController extends Controller
{
    public function index()
    {
       
        $address = Setting::firstOrCreate(['key' => 'contact_address'], ['value' => 'Jl. Sinar Rembulan No.151...']);
        $email = Setting::firstOrCreate(['key' => 'contact_email'], ['value' => 'ritecs.publisher@gmail.com']);
        $phone = Setting::firstOrCreate(['key' => 'contact_phone'], ['value' => '+6281390920585']);
        $site = Setting::firstOrCreate(['key' => 'contact_site'], ['value' => 'https://ritecs.org']);
        $map_link = Setting::firstOrCreate(['key' => 'contact_map_link'], ['value' => 'https://www.google.com/maps/embed?pb=...']);

        return view('backend.pages.contact.index', [
            'title' => 'Manage Contact Info',
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'site' => $site,
            'map_link' => $map_link,
        ]);
    }

    public function update(Request $request)
    {
       
        $request->validate([
            'contact_address' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'contact_site' => 'required|string',
            'contact_map_link' => 'required|url',
        ]);

        
        Setting::updateOrCreate(['key' => 'contact_address'], ['value' => $request->input('contact_address')]);
        Setting::updateOrCreate(['key' => 'contact_email'], ['value' => $request->input('contact_email')]);
        Setting::updateOrCreate(['key' => 'contact_phone'], ['value' => $request->input('contact_phone')]);
        Setting::updateOrCreate(['key' => 'contact_site'], ['value' => $request->input('contact_site')]);
        Setting::updateOrCreate(['key' => 'contact_map_link'], ['value' => $request->input('contact_map_link')]);

        return redirect()->route('admin.page.contact.index')->with('success', 'Informasi kontak berhasil diperbarui!');
    }
}