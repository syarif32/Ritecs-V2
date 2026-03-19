<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Awarding;
use App\Models\Keyword;
use Illuminate\Support\Facades\File;
use App\Models\ContentLog;
use Illuminate\Support\Facades\Auth;

class AwardingController extends Controller
{
    // List semua awarding
    public function index()
    {
        // eager load keywords untuk efisiensi
        $awardings = Awarding::with('keywords')->orderBy('created_at', 'desc')->get();

        return view('backend.pages.awarding.awarding-data', compact('awardings'), [
            'title' => 'Awarding Data'
        ]);
    }


    public function create()
    {
        $allKeywords = Keyword::all();
        return view('backend.pages.awarding.add-awarding', [
            'title' => 'Add Awarding',
            'allKeywords' => $allKeywords
        ]);
    }


    // Store awarding baru
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'url_path'   => 'nullable|url',
            'keywords'   => 'array',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $award = new Awarding();
        $award->title        = $request->title;
        $award->penulis      = $request->penulis;     
        $award->abstract     = $request->abstract;    
        $award->volume_no    = $request->volume_no;   
        $award->jenis_jurnal = $request->jenis_jurnal;
        $award->url_path     = $request->url_path;

        // Upload cover
        // GUNAKAN INI KETIKA DI SERVER LOCAL
        // $destination = public_path('assets/published/awarding'); 
        // if (!file_exists($destination)) {
        //     mkdir($destination, 0755, true);
        // }

        // Upload cover
        // GUNAKAN INI KETIKA DI SERVER HOSTING
        $destination = public_assets_path('assets/published/awarding'); 
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        if ($request->hasFile('coverImage')) {
            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $award->cover_path = 'assets/published/awarding/' . $filename;
        }
        // Kalau tidak ada file, otomatis pakai default dari model

        $award->save();
ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'CREATE', 
    'content_type' => get_class($award),
    'content_id'   => $award->awarding_id,
    'description'  => "Menambahkan awarding: " . $award->title
]);
        // Sinkronisasi keywords
        if (!empty($request->keywords)) {
            $keywords = array_filter($request->keywords, fn($value) => !empty($value));
            $award->keywords()->sync($keywords);
        }

        return redirect()->route('admin.awardings.index')->with('success', 'Awarding added successfully.');
    }

    // Form edit
    public function edit($id)
    {
        $award = Awarding::where('awarding_id', $id)->with('keywords')->firstOrFail();
        $allKeywords = Keyword::all();

        return view('backend.pages.awarding.edit-awarding', [
            'title' => 'Edit Awarding',
            'award' => $award,
            'allKeywords' => $allKeywords
        ]);
    }

    // Update awarding
    public function update(Request $request, $id)
    {
        $award = Awarding::where('awarding_id', $id)->firstOrFail();

        $request->validate([
        'title'       => 'required|string|max:255',
        'penulis'     => 'nullable|string|max:255',
        'abstract'    => 'nullable|string',
        'volume_no'   => 'nullable|string|max:50',
        'jenis_jurnal'=> 'nullable|string|max:100',
        'url_path'    => 'nullable|url',
        'keywords'    => 'array',
        'coverImage'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // update field
    $award->title        = $request->title;
    $award->penulis      = $request->penulis;
    $award->abstract     = $request->abstract;
    $award->volume_no    = $request->volume_no;
    $award->jenis_jurnal = $request->jenis_jurnal;
    $award->url_path     = $request->url_path;

        // Handle cover image upload
        if ($request->hasFile('coverImage')) {
            // Hapus file lama kalau bukan default
            // LOCAL
            // if ($award->cover_path && $award->cover_path !== 'assets/published/awarding/award_default.png') {
            //     $oldPath = public_path($award->cover_path);
            //     if (File::exists($oldPath)) {
            //         File::delete($oldPath);
            //     }
            // }

            // HOSTING
            if ($award->cover_path && $award->cover_path !== 'assets/published/awarding/award_default.png') {
                $oldPath = public_assets_path($award->cover_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // LOCAL 
            // $destination = public_path('assets/published/awarding');
            // if (!file_exists($destination)) {
            //     mkdir($destination, 0755, true);
            // }
            // HOSTING
            $destination = public_assets_path('assets/published/awarding');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $award->cover_path = 'assets/published/awarding/' . $filename;
        }

        $award->save();
        ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'UPDATE', 
    'content_type' => get_class($award),
    'content_id'   => $award->awarding_id,
    'description'  => "Memperbarui awarding: " . $award->title
]);
        // Update keywords
        if ($request->has('keywords')) {
            $keywords = array_filter($request->keywords, fn($value) => !empty($value));
            $award->keywords()->sync($keywords);
        } else {
            $award->keywords()->detach();
        }

        return redirect()->route('admin.awardings.index')->with('success', 'Awarding updated successfully.');
    }

    // Delete awarding
    public function destroy($id)
    {
        $award = Awarding::where('awarding_id', $id)->firstOrFail();

        // Hapus cover
        // LOCAL
        // if ($award->cover_path && $award->cover_path !== 'assets/published/awarding/award_default.png') {
        //     $coverPath = public_path($award->cover_path);
        //     if (file_exists($coverPath)) {
        //         unlink($coverPath);
        //     }
        // }

        // HOSTING
        if ($award->cover_path && $award->cover_path !== 'assets/published/awarding/award_default.png') {
            $coverPath = public_assets_path($award->cover_path);
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
        }

        // Hapus relasi keyword
        $award->keywords()->detach();

        // Hapus awarding
        $award->delete();
        ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'DELETE',
    'content_type' => get_class($award),
    'content_id'   => $award->awarding_id,
    'description'  => "Menghapus awarding: " . $award->title
]);
        return redirect()->route('admin.awardings.index')->with('success', 'Awarding deleted successfully.');
    }
}


