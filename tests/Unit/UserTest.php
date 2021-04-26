<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_if_user_columns_is_correct()
    {
        $user = new User;
        $expected = [
            'name',
            'cpf_cnpj',
            'email',
            'password',
            'type'
        ];

        $arrayCompared = array_diff($expected, $user->getFillable());
        $this->assertEquals(0, count($arrayCompared));
    }
}
