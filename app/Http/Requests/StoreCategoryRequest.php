<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|unique:categories,name',
            'description' => 'nullable|sometimes|string',
        ];
    }
}
