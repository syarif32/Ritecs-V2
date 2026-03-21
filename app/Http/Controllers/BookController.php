<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Writer;
use App\Models\User;
use App\Models\ContentLog;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
    {
    public function incrementVisit($id) {
    $book = \App\Models\Book::findOrFail($id);
    $book->increment('visitor_count');
    return response()->json(['message' => 'Visit ditambahkan']);
}

public function incrementDownload($id) {
    $book = \App\Models\Book::findOrFail($id);
    $book->increment('download_count');
    return response()->json(['message' => 'Download ditambahkan']);
}
    }