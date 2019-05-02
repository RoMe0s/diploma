<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * LoginController constructor.
     */
    function __construct()
    {
        $this->middleware('guest')->except(['user', 'logout']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated()
    {
        return response()->json(['redirectTo' => $this->redirectPath()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loggedOut(Request $request)
    {
        return response()->json(['redirectTo' => $this->redirectPath()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json(compact('user'));
    }
}
