<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\PasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function __invoke(PasswordUpdateRequest $request)
    {
        $user = $request->user();
        $user->setAttribute('password', Hash::make($request->input('password')));
        $user->setRememberToken(null);
        $user->save();

        return response()->noContent();
    }
}
