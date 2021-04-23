<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'payer_user_id',
        'payee_user_id',
        'value',
        'reason',
        'status'
    ];

    public function payer()
    {
        return $this->hasOne(User::class, 'id', 'payer_user_id');
    }

    public function payee()
    {
        return $this->hasOne(User::class, 'id', 'payee_user_id');
    }
}
