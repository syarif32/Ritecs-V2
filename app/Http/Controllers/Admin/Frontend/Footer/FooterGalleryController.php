<?php

namespace App\Http\Controllers\Admin\Frontend\Footer;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Footer\FooterGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterGalleryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('footer-gallery', 'public');
        }

        FooterGallery::create($validated);
        return redirect()->route('admin.page.footer.index')->with('success', 'Gambar galeri berhasil ditambahkan.');
    }

    public function update(Request $request, FooterGallery $footerGallery)
    {
        $validated = $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image_path')) {
            if ($footerGallery->image_path) {
                Storage::disk('public')->delete($footerGallery->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('footer-gallery', 'public');
        }

        $footerGallery->update($validated);
        return redirect()->route('admin.page.footer.index')->with('success', 'Gambar galeri berhasil diperbarui.');
    }

    public function destroy(FooterGallery $footerGallery)
    {
        if ($footerGallery->image_path) {
            Storage::disk('public')->delete($footerGallery->image_path);
        }
        $footerGallery->delete();
        return redirect()->route('admin.page.footer.index')->with('success', 'Gambar galeri berhasil dihapus.');
    }
}