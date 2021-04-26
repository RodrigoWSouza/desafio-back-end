<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class PayerIsNotCompany implements Rule
{
    public function passes($attribute, $user_id)
    {
        $user = User::findOrFail($user_id);
        return ($user->type === 'person');
    }

    public function message()
    {
        return 'The payer can\'t be a company.';
    }
}
