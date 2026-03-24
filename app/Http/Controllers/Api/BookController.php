<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function incrementVisit($id) {
        $book = Book::findOrFail($id);
        $book->increment('visitor_count');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Visit ditambahkan',
            'current_visit' => $book->visitor_count
        ]);
    }

    public function incrementDownload($id) {
        $book = Book::findOrFail($id);
        $book->increment('download_count');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Download ditambahkan',
            'current_download' => $book->download_count
        ]);
    }
}