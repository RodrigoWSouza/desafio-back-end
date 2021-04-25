<?php

namespace App\Http\Requests;

use App\Rules\PayerHasValue;
use App\Rules\PayerIsCompany;
use Illuminate\Foundation\Http\FormRequest;

class TransactionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->value);
        return [
            'value' => ['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'payer' => ['required','exists:users,id', new PayerIsCompany, new PayerHasValue($this->value)],
            'payee' => ['required','exists:users,id','different:payer'],
        ];
    }
}
