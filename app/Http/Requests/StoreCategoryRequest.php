<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required','string', Rule::unique('categories', 'name')->ignore($this->category?->id)],
            'description' => 'nullable|sometimes|string',
        ];
    }
}
