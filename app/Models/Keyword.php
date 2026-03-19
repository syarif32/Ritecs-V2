<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keywords';
    protected $primaryKey = 'keyword_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name'];

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_keyword', 'keyword_id', 'journal_id');
    }
    
    public function awardings()
    {
        return $this->belongsToMany(Awarding::class, 'awarding_keyword', 'keyword_id', 'awarding_id')
                    ->withTimestamps();
    }


}
