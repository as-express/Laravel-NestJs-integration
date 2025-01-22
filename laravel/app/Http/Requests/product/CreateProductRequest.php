<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'count' => 'required|int',
            'price' => 'required|int',
            'category_id' => 'required',
            'description' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'count.required' => 'Count is required',
            'price.required' => 'Price is required',
            'category_id.required' => 'Category Id is required',
            'description.required' => 'Description is required'
        ];
    }
}
