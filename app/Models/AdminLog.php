<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    
    public function actor()
    {
        
        return $this->belongsTo(User::class, 'actor_id', 'user_id');
    }

    
    public function target()
    {
        
        return $this->belongsTo(User::class, 'target_id', 'user_id');
    }
}