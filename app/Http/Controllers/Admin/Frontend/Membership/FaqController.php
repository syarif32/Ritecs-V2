<?php

namespace App\Http\Controllers\Admin\Frontend\Membership;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Membership\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function create() {
        return view('backend.page.membership.faqs.form', ['title' => 'Add FAQ']);
    }
    public function store(Request $request) {
        $request->validate(['question' => 'required', 'answer' => 'required']);
        Faq::create($request->all());
        return redirect()->route('admin.page.membership.index')->with('success', 'FAQ berhasil ditambahkan.');
    }
    public function edit(Faq $faq) {
        return view('backend.page.membership.faqs.form', ['title' => 'Edit FAQ', 'faq' => $faq]);
    }
    public function update(Request $request, Faq $faq) {
        $request->validate(['question' => 'required', 'answer' => 'required']);
        $faq->update($request->all());
        return redirect()->route('admin.page.membership.index')->with('success', 'FAQ berhasil diperbarui.');
    }
    public function destroy(Faq $faq) {
        $faq->delete();
        return redirect()->route('admin.page.membership.index')->with('success', 'FAQ berhasil dihapus.');
    }
}