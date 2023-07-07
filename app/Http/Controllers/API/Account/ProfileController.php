<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->update($request->validated());

        return response()->json([
            'data' => $request->user()->fresh(),
        ]);
    }
}
