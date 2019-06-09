<?php

namespace App\Services\Balance;

use App\Models\Balance\Balance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LiqPay;

class Refill
{
    /**
     * @var LiqPay
     */
    private $liqPay;

    /**
     * Refill constructor.
     */
    function __construct()
    {
        $this->liqPay = new LiqPay(env('LIQ_PAY_PUB'), env('LIQ_PAY_PRIV'));
    }

    /**
     * @param Balance $balance
     * @param array $data
     * @throws \Exception
     */
    public function refill(Balance $balance, array $data): void
    {
        $data['id'] = (string)Str::uuid();
        $data['card'] = $balance->bill;
        $response = $this->sendRequest($data);
        if ($response->result === 'ok' && $response->status === 'success') {
            $this->save($balance, $response);
            return;
        }
        throw new \Exception('Refill error');
    }

    /**
     * @param array $data
     * @return \stdClass
     */
    private function sendRequest(array $data): \stdClass
    {
        return $this->liqPay->api('request', [
            'action' => 'pay',
            'version' => '3',
            'phone' => '380950000001', //TODO: add real phone number from user
            'currency' => 'UAH',
            'description' => __('messages.balance refill'),
            'order_id' => $data['id'],
            'card' => $data['card'],
            'amount' => $data['amount'],
            'card_exp_month' => $data['exp_month'],
            'card_exp_year' => $data['exp_year'],
            'card_cvv' => $data['cvv']
        ]);
    }

    /**
     * @param Balance $balance
     * @param \stdClass $response
     */
    private function save(Balance $balance, \stdClass $response): void
    {
        $newAmount = $balance->amount + $response->amount;
        DB::transaction(function () use ($balance, $response, $newAmount) {
            $balance->transactions()->create([
                'id' => $response->order_id,
                'before' => $balance->amount,
                'after' => $newAmount,
                'notice' => $balance->bill
            ]);
            $balance->update(['amount' => $newAmount]);
        });
    }
}