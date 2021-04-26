<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class PayerHasValue implements Rule
{

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function passes($attribute, $user_id)
    {
        $user = User::with('wallet')->find($user_id);
        return (
            $user->wallet->value > 0
            && $user->wallet->value > $this->value
            && $this->value > 0
        );
    }

    public function message()
    {
        return 'The payer has no balance realize this transaction.';
    }
}
