<?php

namespace App\Http\Controllers\Admin\Frontend\Haki;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Haki\HakiType;
use Illuminate\Http\Request;

class HakiTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['icon' => 'required|string', 'name' => 'required|string|max:255']);
        HakiType::create($request->all());
        return redirect()->route('admin.page.haki.index')->with('success', 'Jenis HAKI berhasil ditambahkan.');
    }

    public function update(Request $request, HakiType $hakiType)
    {
        $request->validate(['icon' => 'required|string', 'name' => 'required|string|max:255']);
        $hakiType->update($request->all());
        return redirect()->route('admin.page.haki.index')->with('success', 'Jenis HAKI berhasil diperbarui.');
    }

    public function destroy(HakiType $hakiType)
    {
        $hakiType->delete();
        return redirect()->route('admin.page.haki.index')->with('success', 'Jenis HAKI berhasil dihapus.');
    }
}