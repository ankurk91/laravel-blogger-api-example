<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_password' => ['required', 'password'],
            'password' => ['required', 'different:current_password', 'confirmed', Password::defaults()],
        ];
    }
}
