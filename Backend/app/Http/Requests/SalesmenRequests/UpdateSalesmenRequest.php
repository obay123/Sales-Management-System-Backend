<?php

namespace App\Http\Requests\SalesmenRequests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesmenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|string|max:10',
            'name' => [
                'sometimes',
                'string',
                Rule::unique('salesmens', 'name')->ignore($this->route('salesman')->code, 'code'),
            ],
            'phone' => 'sometimes|string|max:12',
            'address' => 'sometimes|nullable|string|max:225',
            'is_inactive' => 'sometimes|boolean',
        ];
    }
}
