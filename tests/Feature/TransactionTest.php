<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;
    public function test_required_filds()
    {
        $user = factory(User::class)->create()->refresh();
        $user->wallet = null;

        $this->assertEquals(
            '{"message":"The given data was invalid.","errors":{"value":["The value field is required."],"payer_user_id":["The payer user id field is required."],"payee_user_id":["The payee user id field is required."]}}', $this->postJson('api/transaction')->content()
        );
    }

    public function test_company_payer_is_invalid()
    {
        $company = factory(User::class)->create(
            [
                'type' => 'company'
            ]
        )->refresh();
        $company->wallet()->save(factory(Wallet::class)->make());

        $user = factory(User::class)->create()->refresh();
        $user->wallet()->save(factory(Wallet::class)->make());

        $response = $this->postJson('/api/transaction', [
            'payer_user_id' => $company->id,
            'payee_user_id' => $user->id,
            'value' => 5.00
        ]);
        $this->assertEquals(
            '{"message":"The given data was invalid.","errors":{"payer_user_id":["The payer can\'t be a company."]}}', $response->content()
        );
    }

    public function test_payee_and_payer_are_different()
    {
        $user = factory(User::class)->create(
            [
                'type' => 'person'
            ]
        )->refresh();
        $user->wallet()->save(factory(Wallet::class)->make());

        $response = $this->postJson('/api/transaction', [
            'payer_user_id' => $user->id,
            'payee_user_id' => $user->id,
            'value' => 10.00
        ]);
        $this->assertEquals(
            '{"message":"The given data was invalid.","errors":{"payee_user_id":["The payee user id and payer user id must be different."]}}', $response->content()
        );
    }

    public function test_if_value_is_valid()
    {
        $user = factory(User::class)->create(
            [
                'type' => 'person'
            ]
        )->refresh();
        $user->wallet()->save(factory(Wallet::class)->make());

        $user2 = factory(User::class)->create(
            [
                'type' => 'person'
            ]
        )->refresh();
        $user2->wallet()->save(factory(Wallet::class)->make());


        $response = $this->postJson('/api/transaction', [
            'payer_user_id' => $user->id,
            'payee_user_id' => $user2->id,
            'value' => 100.546545
        ]);
        $this->assertEquals(
            '{"message":"The given data was invalid.","errors":{"value":["The value format is invalid."]}}', $response->content()
        );
    }

}
