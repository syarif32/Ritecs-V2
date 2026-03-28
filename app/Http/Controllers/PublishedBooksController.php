<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Writer;
use App\Models\User;
use App\Models\ContentLog;
use Illuminate\Support\Facades\Auth;

class PublishedBooksController extends Controller
{
    // List semua buku
    public function bookData(Request $request) 
    {
        $books = Book::with([
            'categories', 
            'writers' => function($query) {
                $query->orderBy('book_writer.order', 'asc');
            }
        ])->orderBy('created_at', 'desc')->get();
        
        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) {
            $mapped = $books->map(function($b) {
                return [
                    'book_id' => $b->book_id,
                    'title' => $b->title,
                    'synopsis' => $b->synopsis,
                    'publisher' => $b->publisher,
                    'isbn' => $b->isbn,
                    'publish_date' => $b->publish_date,
                    'cover_path' => $b->cover_path ? asset($b->cover_path) : null,
                    'categories' => $b->categories->map(function($c) { return ['id' => $c->id, 'name' => $c->name]; }),
                    'writers' => $b->writers->map(function($w) { return ['id' => $w->id, 'name' => $w->name]; })
                ];
            });
            return response()->json(['status' => 'success', 'data' => $mapped]);
        }
        // ---------------------------------

        return view('backend.pages.published-books.books-data', compact('books'), ['title' => 'Book Data']);
    }

    // Form create 
    public function bookCreate(Request $request) // <- Tambah Request
    {
        $categories = Category::all();
        $writers    = Writer::all();
        $users      = User::select('user_id','first_name','last_name','email')->get();

        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'categories' => $categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
                    'writers' => $writers->map(fn($w) => ['id' => $w->id, 'name' => $w->name])
                ]
            ]);
        }
        // ---------------------------------

        return view('backend.pages.published-books.add-books', compact('categories', 'writers', 'users'), ['title' => 'Book Data']);
    }

    // Store buku baru
    public function bookStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|array|min:1',
            'writter' => 'required|array|min:1',
            'isbn' => 'nullable|unique:books,isbn',
            'ebook_path' => 'nullable|url',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->synopsis = $request->Synopsis ?? null; 
        $book->publisher = $request->publisher ?? null;
        $book->pages = $request->pages ?? null;
        $book->width = $request->width ?? null;
        $book->length = $request->length ?? null;
        $book->thickness = $request->thickness ?? null;
        $book->publish_date = $request->publish_date ?? null;
        $book->isbn = $request->isbn ?? null;
        $book->ebook_path = $request->ebook_path ?? null;
        $book->print_price = $request->print_price ?? null;
        $book->ebook_price = $request->ebook_price ?? null;

        $destination = public_assets_path('assets/published/books'); 
        if (!file_exists($destination)) mkdir($destination, 0755, true);
        
        if ($request->hasFile('coverImage')) {
            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $book->cover_path = 'assets/published/books/' . $filename;
        }

        $book->save();
        
        ContentLog::create([
            'user_id'      => Auth::user()->user_id,
            'action'       => 'CREATE',
            'content_type' => get_class($book),
            'content_id'   => $book->book_id,
            'description'  => "Menambahkan buku baru berjudul: " . $book->title
        ]);

        $book->categories()->sync($request->category);
        
        $writersWithOrder = [];
        foreach ($request->writter as $index => $writerId) {
            $writersWithOrder[$writerId] = ['order' => $index + 1];
        }
        $book->writers()->sync($writersWithOrder);

        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'Book added successfully.']);
        return redirect()->route('admin.published-books')->with('success', 'Book added successfully.');
    }

    // Edit form
    public function bookEdit($id)
    {
        $book = Book::with(['categories', 'writers' => function($query) { $query->orderBy('book_writer.order', 'asc'); }])->findOrFail($id);
        $categories = Category::all();
        $writers    = Writer::all();
        $users      = User::select('user_id','first_name','last_name','email')->get();
        return view('backend.pages.published-books.edit-books', compact('book', 'categories', 'writers', 'users'), ['title' => 'Book Data']);
    }

    // Update
    public function bookUpdate(Request $request, $id)
    {
        // LOGIKA ASLI TIDAK DISENTUH
        $book = Book::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|array|min:1',
            'writter' => 'required|array|min:1',
            'isbn' => 'nullable|unique:books,isbn,' . $book->book_id . ',book_id',
            'ebook_path' => 'nullable|url',
        ]);
    
        $book->title = $request->title;
        $book->synopsis = $request->Synopsis ?? null;
        $book->publisher = $request->publisher ?? null;
        $book->pages = $request->pages ?? null;
        $book->width = $request->width ?? null;
        $book->length = $request->length ?? null;
        $book->thickness = $request->thickness ?? null;
        $book->publish_date = $request->publish_date ?? null;
        $book->isbn = $request->isbn ?? null;
        $book->ebook_path = $request->ebook_path ?? null;
        $book->print_price = $request->print_price ?? null;
        $book->ebook_price = $request->ebook_price ?? null;
    
        if ($request->hasFile('coverImage')) {
            $defaultCover = 'assets/published/books/book_default.png';
            if ($book->cover_path && $book->cover_path !== $defaultCover) {
                $oldPath = public_assets_path($book->cover_path);
                if (file_exists($oldPath)) unlink($oldPath);
            }
        
            $destination = public_assets_path('assets/published/books');
            if (!file_exists($destination)) mkdir($destination, 0755, true);
            
            $filename = time() . '_' . $request->file('coverImage')->getClientOriginalName();
            $request->file('coverImage')->move($destination, $filename);
            $book->cover_path = 'assets/published/books/' . $filename;
        }

        $book->save();
        
        ContentLog::create([
            'user_id'      => Auth::user()->user_id,
            'action'       => 'UPDATE',
            'content_type' => get_class($book),
            'content_id'   => $book->book_id,
            'description'  => "Memperbarui buku berjudul: " . $book->title
        ]);

        $book->categories()->sync($request->category);
        
        $writersWithOrder = [];
        foreach ($request->writter as $index => $writerId) {
            $writersWithOrder[$writerId] = ['order' => $index + 1];
        }
        $book->writers()->sync($writersWithOrder);
    
        // --- TAMBAHAN UNTUK MOBILE API ---
        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'Book updated successfully.']);
        // ---------------------------------

        return redirect()->route('admin.published-books')->with('success', 'Book updated successfully.');
    }

    // Delete
    public function bookDelete(Request $request, $id) // <- Tambah Request
    {
        $book = Book::findOrFail($id);
        $defaultCover = 'assets/published/books/book_default.png';

        if ($book->cover_path && $book->cover_path !== $defaultCover) {
            $oldPath = public_assets_path($book->cover_path);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $book->categories()->detach();
        $book->writers()->detach();
        $book->delete();
        
        ContentLog::create([
            'user_id'      => Auth::user()->user_id,
            'action'       => 'DELETE',
            'content_type' => get_class($book), 
            'content_id'   => $book->book_id,
            'description'  => "Menghapus buku berjudul: " . $book->title
        ]);
        
        if ($request->expectsJson()) return response()->json(['status' => 'success', 'message' => 'Book deleted successfully.']);

        return redirect()->route('admin.published-books')->with('success', 'Book deleted successfully.');
    }
}