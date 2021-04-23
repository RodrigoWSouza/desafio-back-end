<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'email',
        'password',
        'type'
    ];

    protected $hidden = [
        'password',
    ];

    public function wallets()
    {
        return $this->hasOne(Wallet::class);
    }

}
