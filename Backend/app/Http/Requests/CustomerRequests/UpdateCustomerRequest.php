<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                Rule::unique('customers')->ignore($this->route('customer')->id),
            ],
            'tel1' => 'sometimes|string|max:20',
            'tel2' => 'nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'gender' => 'sometimes|in:male,female',
            'subscription_date' => 'sometimes|date',
            'rate' => 'sometimes|integer|min:1|max:5',
            'photo' => 'sometimes|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
        ];
    }
}
