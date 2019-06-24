<?php

namespace App\Services\Balance;

use App\Models\Balance\Balance;
use App\Services\Price\Customer as CustomerPrice;

class Customer
{
    /**
     * @var Balance
     */
    private $balance;

    /**
     * @param Balance $balance
     */
    public function setBalance(Balance $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return CustomerPrice::convert($this->balance->amount);
    }

    /**
     * @return float
     */
    public function getLocked(): float
    {
        $lockedAmount = $this->balance->lockedChunks()->sum('amount');
        return CustomerPrice::convert($lockedAmount);
    }

    /**
     * @return float
     */
    public function getAvailable(): float
    {
        $locked = $this->getLocked();
        $amount = $this->getAmount();
        return $amount - $locked;
    }
}
