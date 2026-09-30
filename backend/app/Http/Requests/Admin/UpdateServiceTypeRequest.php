<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serviceTypeId = $this->route('service_type')?->id ?? $this->route('service_type');

        return [
            'name'        => ['sometimes', 'required', 'string', 'max:150', 'unique:service_types,name,' . $serviceTypeId],
            'description' => ['nullable', 'string'],
            'cost'        => ['sometimes', 'required', 'numeric', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
}