<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'max:10000'],
            'categories' => ['nullable', 'distinct', 'array', 'max:5'],
            'categories.*' => ['required', 'integer', Rule::exists(Category::class, 'id')],
        ], $this->featuredImageRules());
    }

    protected function featuredImageRules()
    {
        return [
            'featured_image' => [
                'bail',
                'nullable',
                'image',
                'dimensions:min_width=640,min_height=480',
                'mimes:jpeg,jpg,png',
                'max:4096', // KB
            ],
        ];
    }
}
