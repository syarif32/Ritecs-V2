<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
use App\Notifications\ResetPassword; 
use Laravel\Sanctum\HasApiTokens;
/**
 * @method bool hasRole(string|array $roles)
 * @method bool hasAnyRole(string|array $roles)
 * @method \Spatie\Permission\Models\Role[] getRoleNames()
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'nik',
        'birthday',
        'phone',
        'address',
        'city',
        'institution',
        'province',   
        'img_path',
        'ktp_path',
        'acc_status',
        'google_id', 
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }


    public function membership()
    {
        return $this->hasOne(Membership::class, 'user_id', 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

}
