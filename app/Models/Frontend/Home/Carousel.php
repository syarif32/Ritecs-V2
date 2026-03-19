<?php
namespace App\Models\Frontend\Home;
use Illuminate\Database\Eloquent\Model;
class Carousel extends Model {
    protected $fillable = ['pre_title', 'title','subtitle', 'description', 'image_path', 'button1_text', 'button1_url', 'button2_text', 'button2_url'];
}