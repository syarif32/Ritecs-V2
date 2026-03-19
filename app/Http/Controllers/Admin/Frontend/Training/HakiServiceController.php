<?php

namespace App\Http\Controllers\Admin\Frontend\Training;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Training\HakiService;
use Illuminate\Http\Request;

class HakiServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        HakiService::create($request->all());
        return redirect()->route('admin.page.training.index')->with('success', 'Layanan HAKI berhasil ditambahkan.');
    }

    public function update(Request $request, HakiService $hakiService)
    {
        $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $hakiService->update($request->all());
        return redirect()->route('admin.page.training.index')->with('success', 'Layanan HAKI berhasil diperbarui.');
    }

    public function destroy(HakiService $hakiService)
    {
        $hakiService->delete();
        return redirect()->route('admin.page.training.index')->with('success', 'Layanan HAKI berhasil dihapus.');
    }
}