<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Keyword;
use Illuminate\Support\Facades\File; 
use App\Models\ContentLog;
use Illuminate\Support\Facades\Auth;

class PublishedJournalsController extends Controller
{
    public function journalData()
    {
        $journals = Journal::with('keywords')->get();

        return view('backend.pages.published-journals.journal-data', compact('journals'), [
            'title' => 'Journal Data'
        ]);
    }

    public function journalEdit($id)
    {
        // Ambil jurnal berdasarkan journal_id
        $journal = Journal::where('journal_id', $id)->with('keywords')->firstOrFail();
        $allKeywords = Keyword::all();

        return view('backend.pages.published-journals.edit-journal', [
            'title' => 'Edit Journal',
            'journal' => $journal,
            'allKeywords' => $allKeywords
        ]);
    }

    public function journalUpdate(Request $request, $id)
    {
        // Ambil jurnal berdasarkan journal_id
        $journal = Journal::where('journal_id', $id)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'url_path' => 'nullable|url',
            'keywords' => 'array',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $journal->title = $request->title;
        $journal->url_path = $request->url_path;

        // Handle cover image upload
        if ($request->hasFile('coverImage')) {
            // Hapus file lama kalau bukan default
            // GUNAKAN INI KETIKA DI SERVER LOCAL
                // if ($journal->cover_path && $journal->cover_path !== 'assets/published/journals/journal_default.png') {
                //     $oldPath = public_path($journal->cover_path);
                //     if (File::exists($oldPath)) {
                //         File::delete($oldPath);
                //     }
                // }

            // Hapus file lama kalau bukan default
            // GUNAKAN INI KETIKA DI SERVER HOSTING
            if ($journal->cover_path && $journal->cover_path !== 'assets/published/journals/journal_default.png') {
                $oldPath = public_assets_path($journal->cover_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            
            // Upload file baru
            // GUNAKAN INI KETIKA DI SERVER LOCAL
                // $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
                // $request->file('coverImage')->move(public_path('assets/published/journals'), $filename);
                // $journal->cover_path = 'assets/published/journals/' . $filename;

            // GUNAKAN INI KETIKA DI SERVER HOSTING
            $destination = public_assets_path('assets/published/journals'); 
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            // Upload file baru
            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $journal->cover_path = 'assets/published/journals/' . $filename;
            
        }

        $journal->save();
ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'UPDATE',
    'content_type' => get_class($journal),
    'content_id'   => $journal->journal_id,
    'description'  => "Memperbarui jurnal: " . $journal->title
]);
        // Filter keyword kosong sebelum sync
        if ($request->has('keywords')) {
            $keywords = array_filter($request->keywords, fn($value) => !empty($value));
            $journal->keywords()->sync($keywords);
        } else {
            $journal->keywords()->detach();
        }

        return redirect()->route('admin.published-journals')->with('success', 'Journal updated successfully.');
    }


    public function journalDelete($id)
    {
        // Hapus jurnal berdasarkan journal_id
        $journal = Journal::where('journal_id', $id)->firstOrFail();

        // Hapus cover jika bukan default
        // GUNAKAN INI KETIKA DI SERVER LOCAL
            // if ($journal->cover_path && $journal->cover_path !== 'assets/published/journals/journal_default.png') {
            //     $coverPath = public_path($journal->cover_path);
            //     if (file_exists($coverPath)) {
            //         unlink($coverPath);
            //     }
            // }

        // Hapus cover jika bukan default
        // GUNAKAN INI KETIKA DI SERVER HOSTING
        if ($journal->cover_path && $journal->cover_path !== 'assets/published/journals/journal_default.png') {
            $coverPath = public_assets_path($journal->cover_path);
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
        }

        // Hapus relasi pivot keywords
        $journal->keywords()->detach();

        // Hapus jurnal
        $journal->delete();
        ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'DELETE',
    'content_type' => get_class($journal),
    'content_id'   => $journal->journal_id,
    'description'  => "Menghapus jurnal: " . $journal->title
]);
        return redirect()->route('admin.published-journals')->with('success', 'Journal deleted successfully.');
    }

    public function journalCreate()
    {
        $allKeywords = Keyword::all();
        return view('backend.pages.published-journals.add-journal', [
            'title' => 'Add Journal',
            'allKeywords' => $allKeywords
        ]);
    }

    public function journalStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url_path' => 'nullable|url',
            'keywords' => 'array',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $journal = new Journal();
        $journal->title = $request->title;
        $journal->url_path = $request->url_path;

        // Handle cover upload jika ada
         // GUNAKAN INI KETIKA DI SERVER LOCAL
            // if ($request->hasFile('coverImage')) {
            //     $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            //     $request->file('coverImage')->move(public_path('assets/published/journals'), $filename);
            //     $journal->cover_path = 'assets/published/journals/' . $filename;
            // }
            
         // GUNAKAN INI KETIKA DI SERVER HOSTING
        $destination = public_assets_path('assets/published/journals'); 
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

        // Handle cover upload jika ada
        if ($request->hasFile('coverImage')) {
            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $journal->cover_path = 'assets/published/journals/' . $filename;
        }
        // Kalau tidak ada file, otomatis pakai default dari model ($attributes)

        $journal->save();
        ContentLog::create([
    'user_id'      => Auth::user()->user_id,
    'action'       => 'CREATE', 
    'content_type' => get_class($journal),
    'content_id'   => $journal->journal_id,
    'description'  => "Mengunggah jurnal: " . $journal->title
]);
        // Sinkronisasi keywords (filter kosong)
        if (!empty($request->keywords)) {
            $keywords = array_filter($request->keywords, fn($value) => !empty($value));
            $journal->keywords()->sync($keywords);
        }

        return redirect()->route('admin.published-journals')
            ->with('success', 'Journal added successfully.');
    }


}
