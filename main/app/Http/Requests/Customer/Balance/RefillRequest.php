<?php

namespace App\Http\Requests\Customer\Balance;

use Illuminate\Foundation\Http\FormRequest;

class RefillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->isCustomer() && $this->user()->balance->bill ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0|digits_between:0,11',
            'exp_month' => 'required|integer|min:0|max:12',
            'exp_year' => 'required|integer|digits:2',
            'cvv' => 'required|integer|digits:3'
        ];
    }
}
