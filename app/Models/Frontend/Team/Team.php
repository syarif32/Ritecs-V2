<?php

namespace App\Models\Frontend\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $primaryKey = 'team_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'position',
        'img_path',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
    ];
}