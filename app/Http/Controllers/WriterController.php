<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use App\Models\User;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    // List all writers
    public function index()
    {
        $writers = Writer::with('user')->get();
        return view('backend.pages.writers.index', compact('writers'), [
            'title' => 'Writers'
        ]);
    }

    // Form create
   public function create()
    {
        $users = User::all()->map(function($user) {
            // Handle jika last_name kosong
            $user->full_name = $user->first_name . ($user->last_name ? ' ' . $user->last_name : '');
            return $user;
        });

        return view('backend.pages.writers.create', compact('users'), [
            'title' => 'Add Writer'
        ]);
    }


    // Store
    public function store(Request $request)
    {
        $request->validate([
            'names'   => 'required|array|min:1',
            'names.*' => 'required|string|max:255|distinct',
            'user_ids'=> 'nullable|array',
            'user_ids.*' => 'nullable|exists:users,user_id'
        ]);

        $added = [];
        $duplicates = [];

        foreach ($request->names as $i => $name) {
            $name = trim($name);
            $userId = $request->user_ids[$i] ?? null;

            if (!empty($name)) {
                if (Writer::where('name', $name)->exists()) {
                    $duplicates[] = $name;
                } else {
                    Writer::create([
                        'name'    => $name,
                        'user_id' => $userId,
                    ]);
                    $added[] = $name;
                }
            }
        }

        if (!empty($duplicates)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Penulis berikut sudah ada: ' . implode(', ', $duplicates));
        }

        if (empty($added)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Tidak ada penulis baru yang berhasil ditambahkan.');
        }

        return redirect()->back()
            ->with('success', 'Penulis berhasil ditambahkan: ' . implode(', ', $added));
    }

    // Form edit
    public function edit($id)
    {
        $writer = Writer::findOrFail($id);

        $users = User::all()->map(function($user) {
            $user->full_name = $user->first_name . ($user->last_name ? ' ' . $user->last_name : '');
            return $user;
        });

        return view('backend.pages.writers.edit', compact('writer', 'users'), [
            'title' => 'Edit Writer'
        ]);
    }


    // Update
    public function update(Request $request, $id)
    {
        $writer = Writer::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255|unique:writers,name,' . $writer->writer_id . ',writer_id',
            'user_id' => 'nullable|exists:users,user_id'
        ]);

        $writer->update([
            'name'    => $request->name,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.writers')
            ->with('success', 'Writer updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        $writer = Writer::findOrFail($id);
        $writer->delete();

        return redirect()->route('admin.writers')->with('success', 'Writer berhasil dihapus.');
    }


}
