<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index()
    {
        $keywords = Keyword::all();
        return view('backend.pages.keywords.index', compact('keywords'), ['title' => 'Keywords']);
    }

    public function create()
    {
        return view('backend.pages.keywords.create', ['title' => 'Add Keyword']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string|max:255|distinct', // distinct antar input
        ]);

        $added = [];
        $duplicates = [];

        foreach ($request->names as $n) {
            $n = trim($n);

            if (!empty($n)) {
                if (Keyword::where('name', $n)->exists()) {
                    $duplicates[] = $n;
                } else {
                    Keyword::create([
                        'name' => $n,
                        'created_at' => now()
                    ]);
                    $added[] = $n;
                }
            }
        }

        if (!empty($duplicates)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Keyword berikut sudah ada di database: ' . implode(', ', $duplicates));
        }

        if (empty($added)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Tidak ada keyword baru yang berhasil ditambahkan.');
        }

        return redirect()->route('admin.keywords')
            ->with('success', 'Keyword berhasil ditambahkan: ' . implode(', ', $added));
    }


    public function edit($id)
    {
        $keyword = Keyword::findOrFail($id);
        return view('backend.pages.keywords.edit', compact('keyword'), ['title' => 'Edit Keyword']);
    }

    public function update(Request $request, $id)
    {
        $keyword = Keyword::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:keywords,name,' . $keyword->keyword_id . ',keyword_id']);

        $keyword->update(['name' => $request->name]);
        return redirect()->route('admin.keywords')->with('success', 'Keyword updated successfully.');
    }

    public function destroy($id)
    {
        Keyword::findOrFail($id)->delete();
        return redirect()->route('admin.keywords')->with('success', 'Keyword deleted successfully.');
    }
}
