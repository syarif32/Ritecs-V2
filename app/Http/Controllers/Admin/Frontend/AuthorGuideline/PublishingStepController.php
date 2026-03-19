<?php

namespace App\Http\Controllers\Admin\Frontend\AuthorGuideline;

use App\Http\Controllers\Controller;
use App\Models\Frontend\AuthorGuideline\PublishingStep;
use Illuminate\Http\Request;

class PublishingStepController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        PublishingStep::create($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Tahap Prosedur berhasil ditambahkan.');
    }

    public function update(Request $request, PublishingStep $publishingStep)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $publishingStep->update($request->all());
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Tahap Prosedur berhasil diperbarui.');
    }

    public function destroy(PublishingStep $publishingStep)
    {
        $publishingStep->delete();
        return redirect()->route('admin.page.author-guideline.index')->with('success', 'Tahap Prosedur berhasil dihapus.');
    }
}