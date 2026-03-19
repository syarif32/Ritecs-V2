<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id','membership_id','amount','status','proof_path',
        'sender_name','sender_bank','bank_id', 'type'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function bank() {
        return $this->belongsTo(Bank::class, 'bank_id', 'bank_id');
    }
    public function membership() {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }


    public function getIdAttribute() {
        return $this->transaction_id;
    }
    
    public function scopeValid($query)
    {
        return $query->where('validate', 1);
    }


}
