<?php

namespace App\Http\Controllers\Admin\Frontend\Training;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Training\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_path'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'schedule'        => 'required|string',
            'contact_person'  => 'required|string',
            'price'           => 'required|string',
            'price_period'    => 'nullable|string',
            'price_note'      => 'nullable|string',
            'button_text'     => 'required|string',
            'whatsapp_number' => [
                'required',
                'numeric',
                'digits_between:10,15',
                'regex:/^62[0-9]+$/', 
            ],
        ]);

       
        $validated['button_url'] = 'https://wa.me/' . $validated['whatsapp_number'];
        unset($validated['whatsapp_number']);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('trainings', 'public');
        }

        Training::create($validated);
        return redirect()->route('admin.page.training.index')
            ->with('success', 'Program pelatihan berhasil ditambahkan.');
    }

    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'image_path'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'schedule'        => 'required|string',
            'contact_person'  => 'required|string',
            'price'           => 'required|string',
            'price_period'    => 'nullable|string',
            'price_note'      => 'nullable|string',
            'button_text'     => 'required|string',
            'whatsapp_number' => [
                'required',
                'numeric',
                'digits_between:10,15',
                'regex:/^62[0-9]+$/',
            ],
        ]);

        
        $validated['button_url'] = 'https://wa.me/' . $validated['whatsapp_number'];
        unset($validated['whatsapp_number']);

        if ($request->hasFile('image_path')) {
            if ($training->image_path) {
                Storage::disk('public')->delete($training->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('trainings', 'public');
        }

        $training->update($validated);
        return redirect()->route('admin.page.training.index')
            ->with('success', 'Program pelatihan berhasil diperbarui.');
    }

    public function destroy(Training $training)
    {
        if ($training->image_path) {
            Storage::disk('public')->delete($training->image_path);
        }
        $training->delete();
        return redirect()->route('admin.page.training.index')
            ->with('success', 'Program pelatihan berhasil dihapus.');
    }
}
