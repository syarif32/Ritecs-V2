<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationRequest extends Model
{
    use HasFactory;

    
    protected $table = 'activation_requests';

   
    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'processed_by'
    ];

    
    public function user()
    {
       
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    
    public function admin()
    {
        return $this->belongsTo(User::class, 'processed_by', 'user_id');
    }
}