<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email:strict', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function payload(): array
    {
        return array_merge($this->only(['name', 'email']), [
            'password' => Hash::make($this->input('password')),
        ]);
    }
}
