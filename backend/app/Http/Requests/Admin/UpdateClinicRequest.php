<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clinicId = $this->route('clinic')?->id ?? $this->route('clinic');

        return [
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
            'name'          => ['sometimes', 'required', 'string', 'max:150', Rule::unique('clinics', 'name')->ignore($clinicId)],
            'room_number'   => ['sometimes', 'required', 'string', 'max:50', Rule::unique('clinics', 'room_number')->ignore($clinicId)],
            'description'   => ['nullable', 'string'],
            'is_active'     => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique'        => 'اسم العيادة مستخدم بالفعل.',
            'room_number.unique' => 'رقم الغرفة/العيادة مستخدم بالفعل.',
        ];
    }
}