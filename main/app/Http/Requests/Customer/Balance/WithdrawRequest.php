<?php

namespace App\Http\Requests\Customer\Balance;

use App\Services\Balance\Customer;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
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
        $balanceHandler = new Customer();
        $balanceHandler->setBalance($this->user()->balance);

        return [
            'amount' => 'required|numeric|min:0|digits_between:0,11|max:' . $balanceHandler->getAvailable()
        ];
    }
}