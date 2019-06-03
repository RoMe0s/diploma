<?php

namespace App\Services\Balance;

use App\Models\Balance\Balance;
use App\Models\Balance\LockedChunk;
use Illuminate\Database\Eloquent\Builder;

class Author
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
        return $this->getAvailable() + $this->getLocked();
    }

    /**
     * @return float
     */
    public function getLocked(): float
    {
        return LockedChunk::query()->whereHas('order.task', function (Builder $builder) {
            $builder->where('user_id', $this->balance->user_id);
        })->sum('amount');
    }

    /**
     * @return float
     */
    public function getAvailable(): float
    {
        return $this->balance->amount;
    }
}