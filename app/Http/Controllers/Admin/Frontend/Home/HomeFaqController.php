<?php

namespace App\Http\Controllers\Admin\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Home\HomeFaq;
use Illuminate\Http\Request;

class HomeFaqController extends Controller
{
   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        HomeFaq::create($request->all());

        return redirect()->route('admin.page.home.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

   
    public function edit(HomeFaq $homeFaq)
    {
        //
    }

   
    public function update(Request $request, HomeFaq $homeFaq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $homeFaq->update($request->all());

        return redirect()->route('admin.page.home.index')->with('success', 'FAQ berhasil diperbarui.');
    }

   
    public function destroy(HomeFaq $homeFaq)
    {
        $homeFaq->delete();
        
        return redirect()->route('admin.page.home.index')->with('success', 'FAQ berhasil dihapus.');
    }
}