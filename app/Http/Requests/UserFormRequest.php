<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
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
        return[
            'name' => 'required',
            'cpf_cnpj' => ['required', Rule::unique('users')->ignore($this->id)],
            'email' => ['required', Rule::unique('users')->ignore($this->id)],
            'password' => 'required',
            'type' => 'required'
        ];
    }
}
