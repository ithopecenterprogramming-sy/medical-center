<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialtyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:specialties,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم التخصص مطلوب.',
            'name.string' => 'اسم التخصص يجب أن يكون نصاً.',
            'name.max' => 'اسم التخصص يجب ألا يتجاوز 150 حرفاً.',
            'name.unique' => 'هذا التخصص موجود بالفعل في النظام.',
            'description.max' => 'الوصف يجب ألا يتجاوز 1000 حرف.',
            'is_active.boolean' => 'قيمة الحالة يجب أن تكون مفعل أو غير مفعل.',
        ];
    }
}