<?php

namespace App\Http\Controllers\Admin\Frontend\AuthorGuideline;

use App\Http\Controllers\Controller;
use App\Models\Frontend\AuthorGuideline\PublishingScheme;
use Illuminate\Http\Request;

class PublishingSchemeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        PublishingScheme::create($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Skema Penerbitan berhasil ditambahkan.');
    }

    public function update(Request $request, PublishingScheme $publishingScheme)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $publishingScheme->update($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Skema Penerbitan berhasil diperbarui.');
    }

    public function destroy(PublishingScheme $publishingScheme)
    {
        $publishingScheme->delete();
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Skema Penerbitan berhasil dihapus.');
    }
}