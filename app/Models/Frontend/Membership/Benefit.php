<?php

namespace App\Models\Frontend\Membership;
use Illuminate\Database\Eloquent\Model;
class Benefit extends Model {
    protected $fillable = ['icon', 'title', 'description', 'is_featured'];
}