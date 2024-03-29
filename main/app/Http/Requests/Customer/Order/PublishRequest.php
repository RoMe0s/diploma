<?php

namespace App\Http\Requests\Customer\Order;

use App\Models\Order\Order;
use App\Rules\Order\Price;
use App\Services\Price\Customer;
use Illuminate\Foundation\Http\FormRequest;

class PublishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['amount' => new Price($this->user())];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        /** @var Order $order */
        $order = $this->route('order');
        $amount = Customer::convert($order->getTotalPrice());
        return ['amount' => $amount];
    }
}
