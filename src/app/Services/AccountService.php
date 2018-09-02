<?php

namespace App\Services;

use App\Helpers\ErrorHelper;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    //
    public function register(array $data)
    {
        DB::beginTransaction();

        // email already registered?
        $record = UserModel::where('email', $data['email'])->first();
        if ($record != null) {
            ErrorHelper::ValidationException("Email already registered", ErrorHelper::ERROR_EMAIL_REGISTERED);
        }

        // nickname alreadu registered?
        $record = UserModel::where('nickname', $data['nickname'])->first();
        if ($record != null) {
            ErrorHelper::ValidationException("Nickname already registered", ErrorHelper::ERROR_NICKNAME_REGISTERED);
        }

        $data['password'] = Hash::make($data['password']);
        $newRecord = UserModel::create($data);

        DB::commit();

        unset($newRecord->password);

        return $newRecord;
    }

    //
    public function signIn(array $data)
    {
        // get user by email
        $user = UserModel::where('email', $data['email'])->select(['id', 'full_name', 'nickname', 'password', 'token'])->first();

        // verify password
        if ($user == null || $user->password != Hash::check($data['password'], $user->password)) {
            ErrorHelper::ValidationException("Invalid email and/or password", ErrorHelper::ERROR_INVALID_CREDENTIALS);
        }

        // generate a token
        $user->token = str_random(64);
        $user->save();

        return $user;
    }

    //
    public function signOut(UserModel $user)
    {
        $user->token = null;
        $user->save();
    }
}