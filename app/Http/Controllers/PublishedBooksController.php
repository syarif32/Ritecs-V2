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
    public function bookData()
    {
        $books = Book::with([
            'categories', 
            'writers' => function($query) {
                $query->orderBy('book_writer.order', 'asc');
            }
        ])->get();
        
        return view('backend.pages.published-books.books-data', compact('books'), 
        ['title' => 'Book Data']);
    }
    // Form create
    public function bookCreate()
    {
        $categories = Category::all();
        $writers    = Writer::all();
        $users      = User::select('user_id','first_name','last_name','email')->get();

        return view(
            'backend.pages.published-books.add-books',
            compact('categories', 'writers', 'users'),
            ['title' => 'Book Data']
        );
    }

    // Store buku baru dengan urutan penulis
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

        // Upload cover
        $destination = public_assets_path('assets/published/books'); 
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        
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

        // Sync categories
        $book->categories()->sync($request->category);
        
        // Sync writers DENGAN URUTAN
        $writersWithOrder = [];
        foreach ($request->writter as $index => $writerId) {
            $writersWithOrder[$writerId] = ['order' => $index + 1];
        }
        $book->writers()->sync($writersWithOrder);

        return redirect()->route('admin.published-books')->with('success', 'Book added successfully.');
    }

    // Edit form
    public function bookEdit($id)
    {
        $book       = Book::with(['categories', 'writers' => function($query) {
            $query->orderBy('book_writer.order', 'asc');
        }])->findOrFail($id);
        
        $categories = Category::all();
        $writers    = Writer::all();
        $users      = User::select('user_id','first_name','last_name','email')->get();

        return view('backend.pages.published-books.edit-books',
            compact('book', 'categories', 'writers', 'users'),
            ['title' => 'Book Data']
        );
    }

    // Update dengan urutan penulis
    public function bookUpdate(Request $request, $id)
    {
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
        
            // Hapus cover lama jika bukan default
            if ($book->cover_path && $book->cover_path !== $defaultCover) {
                $oldPath = public_assets_path($book->cover_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        
            // Pastikan folder tujuan ada
            $destination = public_assets_path('assets/published/books');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            
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

        // Sync categories
        $book->categories()->sync($request->category);
        
        // Sync writers DENGAN URUTAN
        $writersWithOrder = [];
        foreach ($request->writter as $index => $writerId) {
            $writersWithOrder[$writerId] = ['order' => $index + 1];
        }
        $book->writers()->sync($writersWithOrder);
    
        return redirect()->route('admin.published-books')->with('success', 'Book updated successfully.');
    }

    // Delete
    public function bookDelete($id)
    {
        $book = Book::findOrFail($id);

        $defaultCover = 'assets/published/books/book_default.png';

        if ($book->cover_path && $book->cover_path !== $defaultCover) {
            $oldPath = public_assets_path($book->cover_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
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
        
        return redirect()->route('admin.published-books')->with('success', 'Book deleted successfully.');
    }
}