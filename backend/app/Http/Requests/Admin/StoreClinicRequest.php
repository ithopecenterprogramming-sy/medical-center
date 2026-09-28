<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'name'          => ['required', 'string', 'max:150', 'unique:clinics,name'],
            'room_number'   => ['required', 'string', 'max:50', 'unique:clinics,room_number'],
            'description'   => ['nullable', 'string'],
            'is_active'     => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'معرف القسم مطلوب لربط العيادة به.',
            'department_id.exists'   => 'القسم المحدد غير موجود.',
            'name.required'          => 'اسم العيادة مطلوب.',
            'name.unique'            => 'اسم العيادة موجود مسجلاً بالفعل في النظام.',
            'room_number.required'   => 'رقم الغرفة/العيادة مطلوب.',
            'room_number.unique'     => 'رقم الغرفة/العيادة مستخدم بالفعل لعيادة أخرى.',
        ];
    }
}