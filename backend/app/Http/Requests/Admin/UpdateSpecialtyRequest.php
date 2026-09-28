<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialtyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $specialtyId = $this->route('specialty') ? $this->route('specialty')->id : $this->route('id');

        return [
            'name' => [
                'sometimes', 
                'required', 
                'string', 
                'max:150', 
                Rule::unique('specialties', 'name')->ignore($specialtyId)->whereNull('deleted_at')
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم التخصص مطلوب.',
            'name.unique' => 'اسم التخصص مأخوذ بالفعل.',
            'name.max' => 'اسم التخصص يجب ألا يتجاوز 150 حرفاً.',
        ];
    }
}