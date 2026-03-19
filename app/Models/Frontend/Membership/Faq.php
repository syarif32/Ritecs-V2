<?php

namespace App\Models\Frontend\Membership;
use Illuminate\Database\Eloquent\Model;
class Faq extends Model {
    protected $fillable = ['question', 'answer'];
}