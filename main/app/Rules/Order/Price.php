<?php

namespace App\Rules\Order;

use App\Models\User;
use App\Services\Balance\Customer;
use Illuminate\Contracts\Validation\Rule;

class Price implements Rule
{
    /**
     * @var User
     */
    private $customer;

    /**
     * Price constructor.
     * @param User $customer
     */
    public function __construct(User $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param string $attribute
     * @param float $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($balance = $this->customer->balance) {
            $balance = (new Customer($balance))->getAvailable();
            return $balance - $value >= 0;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //TODO: add price into the rule
        return __('validation.order.price');
    }
}
