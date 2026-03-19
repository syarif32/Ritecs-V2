<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentLog extends Model
{
    use HasFactory;

    
    protected $table = 'content_logs';

    
    protected $guarded = []; 

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    
    public function content()
    {
        return $this->morphTo();
    }
}