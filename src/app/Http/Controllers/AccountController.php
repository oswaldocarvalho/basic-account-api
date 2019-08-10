<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //
    public function signIn(Request $request, AccountService $accountService)
    {
        //
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|max:12|min:6'
        ];

        // validate
        $this->validate($request, $rules);

        $result = $accountService->signIn($request->only(array_keys($rules)));

        return response()->make($result,200);
    }

    //
    public function signOut(Request $request, AccountService $accountService)
    {
        $accountService->signOut(Auth::user());
        return response()->make(null,200);
    }

    //
    public function register(Request $request, AccountService $account)
    {
        //
        $rules = [
            'fullName' => 'required|string',
            'nickname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|max:12|min:6'
        ];

        // validate
        $this->validate($request, $rules);

        $result = $account->register($request->only(array_keys($rules)));

        return response()->make($result,201);
    }
}
