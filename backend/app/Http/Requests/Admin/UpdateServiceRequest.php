<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_type_id' => ['sometimes', 'required', 'integer', 'exists:service_types,id'],
            'name'            => ['sometimes', 'required', 'string', 'max:190'],
            'description'     => ['nullable', 'string'],
            'cost'            => ['sometimes', 'required', 'numeric', 'min:0'],
            'is_active'       => ['nullable', 'boolean'],
        ];
    }
}