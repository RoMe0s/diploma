<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\User;
use App\Services\Balance\Customer;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Customer\Balance\UpdateRequest;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * @param Request $request
     * @param Customer $balanceHandler
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Customer $balanceHandler)
    {
        /** @var User $user */
        $user = $request->user();
        $balance = $user->balance;
        $balanceHandler->setBalance($balance);
        return response()->json([
            'bill' => $balance->bill,
            'amount' => $balanceHandler->getAmount(),
            'available' => $balanceHandler->getAvailable(),
            'locked' => $balanceHandler->getLocked()
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
}