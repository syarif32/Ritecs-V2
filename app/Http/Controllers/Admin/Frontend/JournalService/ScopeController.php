<?php

namespace App\Http\Controllers\Admin\Frontend\JournalService;

use App\Http\Controllers\Controller;
use App\Models\Frontend\JournalService\Scope;
use Illuminate\Http\Request;

class ScopeController extends Controller
{
    public function create()
    {
        return view('backend.pages.layanan-jurnal.scopes', ['title' => 'Add Scope']);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Scope::create($request->all());
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Topik Ruang Lingkup berhasil ditambahkan.');
    }

    public function edit(Scope $scope)
    {
        return view('backend.pages.layanan-jurnal.scopes', ['title' => 'Edit Scope', 'scope' => $scope]);
    }

    public function update(Request $request, Scope $scope)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $scope->update($request->all());
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Topik Ruang Lingkup berhasil diperbarui.');
    }

    public function destroy(Scope $scope)
    {
        $scope->delete();
        return redirect()->route('admin.page.journal-service.index')->with('success', 'Topik Ruang Lingkup berhasil dihapus.');
    }
}
