<?php

namespace App\Services\Balance;

use App\Models\Balance\Balance;

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
        return $this->balance->amount;
    }

    /**
     * @return float
     */
    public function getLocked(): float
    {
        $this->balance->loadMissing('lockedChunks');
        return $this->balance->lockedChunks->sum('amount');
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
