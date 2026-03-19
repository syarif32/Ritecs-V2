<?php

namespace App\Models\Frontend\Training;
use Illuminate\Database\Eloquent\Model;
class Training extends Model {
    protected $fillable = ['image_path', 'title', 'description', 'schedule', 'contact_person', 'price', 'price_period', 'price_note', 'button_text', 'button_url'];
    /**
     * Accessor untuk mendapatkan nomor WA dari button_url
     * Logic: Menghapus string 'https://wa.me/' sehingga tersisa angkanya saja
     */
    public function getWhatsappNumberAttribute()
    {
        
        if ($this->button_url) {
            return str_replace('https://wa.me/', '', $this->button_url);
        }
        return null;
    }
}