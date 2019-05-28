<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Customer\Profile\UpdateRequest;
use App\Http\Requests\Customer\Profile\PasswordRequest;
use App\Services\Handlers\Customer\Profile\Update;
use App\Services\Handlers\Customer\Profile\Password;

class ProfileController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @param Update $update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Update $update)
    {
        $update->update($request->user(), $request->validated());
        return response()->json();
    }

    /**
     * @param PasswordRequest $request
     * @param Password $password
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(PasswordRequest $request, Password $password)
    {
        $password->change($request->user(), $request->get('password'));
        return response()->json();
    }
}
