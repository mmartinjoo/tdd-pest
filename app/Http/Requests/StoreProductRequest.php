<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrices(): array
    {
        return $this->prices;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|sometimes|exists:products,id',
            'name' => ['required','string', Rule::unique('products', 'name')->ignore($this->product?->id)],
            'description' => 'nullable|sometimes|string|min:10',
            'prices' => 'required|array',
            'prices.*.fromDate' => 'required|date',
            'prices.*.toDate' => 'required|date',
            'prices.*.price' => 'required|numeric',
            'categoryId' => 'required|exists:categories,id',
        ];
    }
}
