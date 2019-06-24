<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Requests\Author\Balance\WithdrawRequest;
use App\Models\User;
use App\Services\Balance\Author;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Author\Balance\UpdateRequest;
use App\Services\Balance\Withdraw;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * @param Request $request
     * @param Author $balanceHandler
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Author $balanceHandler)
    {
        /** @var User $user */
        $user = $request->user();
        $balance = $user->balance;
        $balanceHandler->setBalance($balance);
        return response()->json([
            'bill' => $balance->bill,
            'amount' => (string)$balanceHandler->getAmount(),
            'available' => (string)$balanceHandler->getAvailable(),
            'locked' => (string)$balanceHandler->getLocked()
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request)
    {
        $balance = $request->user()->balance;
        $this->authorize('update', $balance);
        $balance->update($request->validated());
        return response()->json();
    }

    /**
     * @param WithdrawRequest $request
     * @param Withdraw $withdraw
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function withdraw(WithdrawRequest $request, Withdraw $withdraw)
    {
        $balance = $request->user()->balance;
        $withdraw->withdraw($balance, $request->validated());
        return response()->json();
    }
}
