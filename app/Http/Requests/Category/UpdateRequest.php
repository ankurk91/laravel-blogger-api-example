<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Validation\Rule;

class UpdateRequest extends CreateRequest
{
    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique(Category::class, 'name')->ignoreModel($this->route('category')),
            ],
        ];
    }
}
