<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';
    protected $primaryKey = 'membership_id';
    public $timestamps = true; // otomatis handle created_at & updated_at
    
    protected $fillable = [
        'user_id',
        'guest_first_name',
        'guest_last_name',
        'guest_email',
        'guest_institution',
        'start_date',
        'end_date',
        'member_number',
        'status'
    ];
    
    public function membership()
    {
        return $this->hasOne(Membership::class, 'user_id', 'user_id');
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    // Tambahkan function ini di dalam class Membership
public function getDisplayNameAttribute()
{
    // Jika relasi user ada, kembalikan full_name dari user
    if ($this->user) {
        return $this->user->first_name . ' ' . $this->user->last_name; 
        // Atau return $this->user->full_name; (jika di model User sudah ada accessor full_name)
    }

    // Jika tidak ada user (Guest), gabungkan nama guest
    return trim($this->guest_first_name . ' ' . $this->guest_last_name);
}


}
