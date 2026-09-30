<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:150', 'unique:service_types,name'],
            'description' => ['nullable', 'string'],
            'cost'        => ['required', 'numeric', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نوع الخدمة مطلوب.',
            'name.unique'   => 'اسم نوع الخدمة مسجل مسبقاً.',
            'cost.required' => 'التكلفة مطلوبة.',
            'cost.numeric'  => 'التكلفة يجب أن تكون رقمية.',
        ];
    }
}