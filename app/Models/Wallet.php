<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'value', 'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(user::class);
    }
}
