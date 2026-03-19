<?php

namespace App\Models\Frontend\Haki;
use Illuminate\Database\Eloquent\Model;
class HakiPackage extends Model {
    protected $fillable = ['title', 'old_price', 'new_price', 'description', 'features', 'whatsapp_message','whatsapp_number',];
    protected $casts = ['features' => 'array']; 
}