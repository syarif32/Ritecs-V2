<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipCardSetting extends Model
{
    protected $primaryKey = 'setting_id';
    
    protected $fillable = [
        'front_image_path',
        'back_image_path',
        'name_position',
        'member_number_position',
        'expired_date_position',
        'card_width',
        'card_height',
        'font_file'
    ];

    protected $casts = [
        'name_position' => 'array',
        'member_number_position' => 'array',
        'expired_date_position' => 'array'
    ];

    // Default values
    public static function getSettings()
    {
        $setting = self::first();
        
        if (!$setting) {
            $setting = self::create([
                'name_position' => [
                    'x' => 100,
                    'y' => 300,
                    'font_size' => 48,
                    'color' => '#193763'
                ],
                'member_number_position' => [
                    'x' => 650,
                    'y' => 480,
                    'font_size' => 24,
                    'color' => '#193763'
                ],
                'expired_date_position' => [
                    'x' => 650,
                    'y' => 510,
                    'font_size' => 18,
                    'color' => '#666666'
                ]
            ]);
        }
        
        return $setting;
    }
}