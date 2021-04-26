<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionFormRequest;
use App\Repository\TransactionRepositoryInterface;

class TransactionsController extends Controller
{

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function store(TransactionFormRequest $request)
    {
        $response = $this->transactionRepository->create($request->all());
        return $response;
    }
}
