<?php

namespace Tests\Unit;

use App\Models\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{

    public function test_if_transactions_columns_is_correct()
    {
        $transaction = new Transaction;
        $expected = [
            'payer_user_id',
            'payee_user_id',
            'value',
            'reason',
            'status'
        ];

        $arrayCompared = array_diff($expected, $transaction->getFillable());
        $this->assertEquals(0, count($arrayCompared));
    }
}
