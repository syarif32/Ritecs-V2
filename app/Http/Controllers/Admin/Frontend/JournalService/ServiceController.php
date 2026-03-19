<?php

namespace App\Http\Controllers\Admin\Frontend\JournalService;

use App\Http\Controllers\Controller;
use App\Models\Frontend\JournalService\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
     public function create()
    {
        $icons = config('icons.font_awesome');       
        return view('backend.pages.layanan-jurnal.services', [
            'title' => 'Add Service',
            'icons' => $icons 
        ]);
    }

    public function edit(Service $service)
    {
        $icons = config('icons.font_awesome');
        return view('backend.pages.layanan-jurnal.services', [
            'title' => 'Edit Service', 
            'service' => $service,
            'icons' => $icons 
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        Service::create($request->all());
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Layanan berhasil ditambahkan.');
    }
    

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $service->update($request->all());
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Layanan berhasil dihapus.');
    }
}