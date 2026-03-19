<?php

namespace App\Http\Controllers\Admin\Frontend\AuthorGuideline;

use App\Http\Controllers\Controller;
use App\Models\Frontend\AuthorGuideline\BookType;
use Illuminate\Http\Request;

class BookTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        BookType::create($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Jenis Buku berhasil ditambahkan.');
    }

    public function update(Request $request, BookType $bookType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $bookType->update($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Jenis Buku berhasil diperbarui.');
    }

    public function destroy(BookType $bookType)
    {
        $bookType->delete();
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Jenis Buku berhasil dihapus.');
    }
}