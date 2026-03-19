<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';
    protected $primaryKey = 'journal_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $keyType = 'int';

    // Di model Journal
    protected $attributes = [
        'cover_path' => 'assets/published/journals/journal_default.png',
    ];


    protected $fillable = [
        'title',
        'cover_path',
        'url_path',
    ];

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'journal_keyword', 'journal_id', 'keyword_id');
    }
    
}
