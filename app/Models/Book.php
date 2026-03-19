<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    // Default cover
    protected $attributes = [
        'cover_path' => 'assets/published/books/book_default.png',
    ];

    protected $fillable = [
        'title',
        'synopsis',
        'publisher',
        'pages',
        'width',
        'length',
        'thickness',
        'publish_date',
        'isbn',
        'cover_path',
        'ebook_path',
        'print_price',
        'ebook_price',
    ];

    // Relasi ke Categories (many-to-many)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    // Relasi ke Writers (many-to-many)
    public function writers()
    {
        return $this->belongsToMany(Writer::class, 'book_writer', 'book_id', 'writer_id');
    }
}
