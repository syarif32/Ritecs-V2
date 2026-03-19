<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('backend.pages.categories.index', compact('categories'), ['title' => 'Categories']);
    }

    public function create()
    {
        return view('backend.pages.categories.create', ['title' => 'Add Category']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string|max:255|distinct', // distinct antar input form
        ]);

        $added = [];
        $duplicates = [];

        foreach ($request->names as $n) {
            $n = trim($n);

            if (!empty($n)) {
                // Cek apakah sudah ada di DB
                if (Category::where('name', $n)->exists()) {
                    $duplicates[] = $n;
                } else {
                    Category::create([
                        'name' => $n,
                        'created_at' => now()
                    ]);
                    $added[] = $n;
                }
            }
        }

        // Jika ada yang duplikat di DB → balik ke add form
        if (!empty($duplicates)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Kategori berikut sudah ada di database: ' . implode(', ', $duplicates));
        }

        // Jika semua gagal (misalnya kosong)
        if (empty($added)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Tidak ada kategori baru yang berhasil ditambahkan.');
        }

        // Kalau sukses → balik ke index list
        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil ditambahkan: ' . implode(', ', $added));
    }




    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.pages.categories.edit', compact('category'), ['title' => 'Edit Category']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->category_id . ',category_id',
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
