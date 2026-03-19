<?php

namespace App\Http\Controllers\Admin\Frontend\Haki;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Haki\HakiPackage;
use Illuminate\Http\Request;

class HakiPackageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'old_price'        => 'nullable|numeric', 
            'new_price'        => 'required|numeric', 
            'description'      => 'nullable|string',
            'features'         => 'nullable|string',
            'whatsapp_message' => 'required|string',
            'whatsapp_number'  => [
                'required',
                'numeric',
                'digits_between:10,15',
                'regex:/^62[0-9]+$/', 
            ],
        ]);

      
        if ($request->filled('features')) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        }

       
        $validated['button_url'] = 'https://wa.me/' . $validated['whatsapp_number'];

        HakiPackage::create($validated);
        return redirect()->route('admin.page.haki.index')->with('success', 'Paket HAKI berhasil ditambahkan.');
    }

    public function update(Request $request, HakiPackage $hakiPackage)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'old_price'        => 'nullable|numeric', 
            'new_price'        => 'required|numeric', 
            'description'      => 'nullable|string',
            'features'         => 'nullable|string',
            'whatsapp_message' => 'required|string',
            'whatsapp_number'  => [
                'required',
                'numeric',
                'digits_between:10,15',
                'regex:/^62[0-9]+$/',
            ],
        ]);

        if ($request->filled('features')) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        } else {
            $validated['features'] = [];
        }

      
        $validated['button_url'] = 'https://wa.me/' . $validated['whatsapp_number'];

        $hakiPackage->update($validated);
        return redirect()->route('admin.page.haki.index')->with('success', 'Paket HAKI berhasil diperbarui.');
    }

    public function destroy(HakiPackage $hakiPackage)
    {
        $hakiPackage->delete();
        return redirect()->route('admin.page.haki.index')->with('success', 'Paket HAKI berhasil dihapus.');
    }
}
