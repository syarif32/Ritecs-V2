<?php

namespace App\Http\Controllers\Admin\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Home\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pre_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button1_text' => 'nullable|string',
            'button1_url' => 'nullable|string',
            'button2_text' => 'nullable|string',
            'button2_url' => 'nullable|string',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('carousels', 'public');
        }

        Carousel::create($validated);
        return redirect()->route('admin.page.home.index')->with('success', 'Carousel slide berhasil ditambahkan.');
    }

    public function update(Request $request, Carousel $carousel)
    {
        $validated = $request->validate([
            'pre_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'button1_text' => 'nullable|string',
            'button1_url' => 'nullable|string',
            'button2_text' => 'nullable|string',
            'button2_url' => 'nullable|string',
        ]);

        if ($request->hasFile('image_path')) {
         
            if ($carousel->image_path) {
                Storage::disk('public')->delete($carousel->image_path);
            }
           
            $validated['image_path'] = $request->file('image_path')->store('carousels', 'public');
        }

        $carousel->update($validated);
        return redirect()->route('admin.page.home.index')->with('success', 'Carousel slide berhasil diperbarui.');
    }

    public function destroy(Carousel $carousel)
    {
        if ($carousel->image_path) {
            Storage::disk('public')->delete($carousel->image_path);
        }
        $carousel->delete();
        return redirect()->route('admin.page.home.index')->with('success', 'Carousel slide berhasil dihapus.');
    }
}