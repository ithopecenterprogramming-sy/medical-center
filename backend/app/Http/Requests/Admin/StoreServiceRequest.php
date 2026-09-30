<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_type_id' => ['required', 'integer', 'exists:service_types,id'],
            'name'            => ['required', 'string', 'max:190'],
            'description'     => ['nullable', 'string'],
            'cost'            => ['required', 'numeric', 'min:0'],
            'is_active'       => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_type_id.required' => 'نوع الخدمة مطلوب.',
            'service_type_id.exists'   => 'نوع الخدمة المختار غير موجود.',
            'name.required'            => 'اسم الخدمة مطلوب.',
            'cost.required'            => 'التكلفة مطلوبة.',
            'cost.numeric'             => 'التكلفة يجب أن تكون رقمية.',
        ];
    }
}