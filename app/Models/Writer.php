<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    protected $table = 'writers';
    protected $primaryKey = 'writer_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_writer', 'writer_id', 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

}
