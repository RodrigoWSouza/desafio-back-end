<?php

namespace App\Http\Requests;

use App\Rules\PayerHasValue;
use App\Rules\PayerIsNotCompany;
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
        return [
            'value' => ['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'payer_user_id' => ['required','exists:users,id', new PayerIsNotCompany, new PayerHasValue($this->value)],
            'payee_user_id' => ['required','exists:users,id','different:payer_user_id'],
        ];
    }
}
