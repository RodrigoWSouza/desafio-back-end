<?php

namespace App\Exceptions;

use Exception;

class PayerInsufficientAmountException extends Exception
{
    public function __construct(string $message = 'Payes has insufficient amount', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
