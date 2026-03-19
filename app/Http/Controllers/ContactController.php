<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment; 
use App\Models\Setting; 

class ContactController extends Controller
{
    public function create()
    {
       
        $address = Setting::where('key', 'contact_address')->first();
        $email = Setting::where('key', 'contact_email')->first();
        $phone = Setting::where('key', 'contact_phone')->first();
        $site = Setting::where('key', 'contact_site')->first();
        $map_link = Setting::where('key', 'contact_map_link')->first();
        
        return view('pages.contact', [
            'title' => 'Contact',
            'address' => $address->value ?? 'Alamat belum diatur',
            'email' => $email->value ?? 'Email belum diatur',
            'phone' => $phone->value ?? 'Telepon belum diatur',
            'site' => $site->value ?? 'Situs belum diatur',
            'map_link' => $map_link->value ?? '',
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Tambahkan Status Default (PENTING!)
        
        $validatedData['status'] = 'pending'; 

        // 3. Simpan menggunakan Model Comment (bukan Contact)
        Comment::create($validatedData); // <--- UBAH INI

        return redirect()->route('contact.create')->with('success', 'Pesan Anda telah berhasil terkirim!');
    }
}