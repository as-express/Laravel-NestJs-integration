<?php

namespace App\Http\Requests\basket;

use Illuminate\Foundation\Http\FormRequest;

class BasketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Quantity is required',
        ];
    }
}
