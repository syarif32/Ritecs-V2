<?php

namespace App\Http\Controllers\Admin\Frontend\Membership;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Membership\Benefit;
use App\Models\Frontend\Membership\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageMembershipController extends Controller
{
    public function index()
    {
        $price = Setting::firstOrCreate(['key' => 'membership_price'], ['value' => '150K']);
        $price_description = Setting::firstOrCreate(['key' => 'membership_price_description'], ['value' => 'Pilihan terbaik untuk akses penuh dan benefit maksimal.']);

        return view('backend.pages.membership.index', [
            'title' => 'Manage Membership Page',
            'price' => $price,
            'price_description' => $price_description,
            'benefits' => Benefit::latest()->get(),
            'faqs' => Faq::latest()->get(),
        ]);
    }

    public function updatePrice(Request $request)
    {
        $request->validate([
            'price' => 'required|string|max:255',
            'price_description' => 'required|string',
        ]);
        Setting::updateOrCreate(['key' => 'membership_price'], ['value' => $request->input('price')]);
        Setting::updateOrCreate(['key' => 'membership_price_description'], ['value' => $request->input('price_description')]);
        return redirect()->route('admin.page.membership.index')->with('success', 'Harga membership berhasil diperbarui!');
    }
}