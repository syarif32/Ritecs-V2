<?php

namespace App\Http\Controllers\Admin\Frontend\Membership;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Membership\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function create() {
        return view('backend.pages.membership.benefits.form', [
            'title' => 'Add Benefit',
            'icons' => config('icons.font_awesome')
        ]);
    }
    public function store(Request $request) {
        $request->validate(['icon' => 'required','title' => 'required','description' => 'required']);
        Benefit::create($request->all());
        return redirect()->route('admin.page.membership.index')->with('success', 'Benefit berhasil ditambahkan.');
    }
    public function edit(Benefit $benefit) {
        return view('backend.pages.membership.benefits.form', [
            'title' => 'Edit Benefit',
            'benefit' => $benefit,
            'icons' => config('icons.font_awesome')
        ]);
    }
    public function update(Request $request, Benefit $benefit) {
        $request->validate(['icon' => 'required','title' => 'required','description' => 'required']);
        $benefit->update($request->all());
        return redirect()->route('admin.page.membership.index')->with('success', 'Benefit berhasil diperbarui.');
    }
    public function destroy(Benefit $benefit) {
        $benefit->delete();
        return redirect()->route('admin.page.membership.index')->with('success', 'Benefit berhasil dihapus.');
    }
}