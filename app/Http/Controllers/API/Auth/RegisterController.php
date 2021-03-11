<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->payload());
        $user->save();

        event(new \Illuminate\Auth\Events\Registered($user));

        return response()->noContent();
    }
}
