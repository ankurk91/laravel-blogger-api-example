<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['bail', 'required', 'email:strict'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }
}
