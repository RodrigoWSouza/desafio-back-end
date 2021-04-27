<?php

namespace App\Repository\Eloquent;

use App\Exceptions\AuthorizationException;
use App\Exceptions\PayerInsufficientAmountException;
use App\Jobs\NotifyJobQueue;
use App\Models\Transaction;
use App\Models\User;
use App\Repository\TransactionRepositoryInterface;
use App\Services\AuthorizationService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{

    public function __construct(Transaction $model)
    {
        parent::__construct($model);
        $this->authorizationService = new AuthorizationService();
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $transaction = $this->model->create($attributes);
            if (!$this->authorizationService->approved($transaction->id)) {
                throw new AuthorizationException();
            }

            $payer = User::find($transaction->payer_user_id);
            if ($transaction->value > $payer->wallet->value) {
                throw new PayerInsufficientAmountException();
            }

            $payee = User::find($transaction->payee_user_id);
            $payer->wallet->decrement('value', $transaction->value);
            $payee->wallet->increment('value', $transaction->value);

            DB::commit();
            dispatch(new NotifyJobQueue(['to' => $payer->email, 'message' => 'Your payment was confirmed']));
            dispatch(new NotifyJobQueue(['to' => $payee->email, 'message' => 'You received a payment']));
        	return response()->json(['success' => 'Payment successful!']);
        } catch(\Throwable $e) {
            DB::rollBack();
            $data = [
                'status' => 'failed',
                'reason' =>  $e->getMessage()
            ];
            $transaction->update($data);

            dispatch(new NotifyJobQueue(['to' => $payer->email, 'message' => 'Your payment was failed']));

            return response()->json([$e], Response::HTTP_BAD_REQUEST);
        }
    }
}
