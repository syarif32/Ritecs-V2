<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Awarding extends Model
{
    use HasFactory;

    protected $table = 'awardings';
    protected $primaryKey = 'awarding_id';

    protected $fillable = [
        'title',
        'penulis',
        'abstract',
        'volume_no',
        'jenis_jurnal',
        'url_path',
        'cover_path',
    ];

    // Relasi Many-to-Many ke Keyword
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'awarding_keyword', 'awarding_id', 'keyword_id')
                    ->withTimestamps();
    }
}
