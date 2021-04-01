<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->ensureIsNotRateLimited();

        if (! Auth::guard('web')->attempt($request->credentials())) {
            $request->increaseRateLimiter();

            throw ValidationException::withMessages([
                'email' => Lang::get('auth.failed'),
            ]);
        }

        /**
         * @var User $user
         */
        $user = Auth::guard('web')->user();

        $token = $user->createToken($request->input('device_name'));

        $request->resetRateLimiter();

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $user->currentAccessToken()->delete();

        event(new \Illuminate\Auth\Events\Logout('sanctum', $user));

        return response()->noContent();
    }
}
