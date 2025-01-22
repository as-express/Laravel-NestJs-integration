<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'count' => 'nullable|int',
            'price' => 'nullable|int',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required_without_all' => 'At least one field must be filled.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'validated_fields' => array_filter($this->only(['title', 'count', 'price', 'description']), function ($value) {
                return !is_null($value) && $value !== '';
            }),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->validated_fields)) {
                $validator->errors()->add('validated_fields', 'At least one field must be filled.');
            }
        });
    }
}
