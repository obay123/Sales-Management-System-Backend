<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'tel1' => 'required|string|max:12', 
            'tel2' => 'nullable|string|max:12',
            'address' => 'nullable|string',
            'gender' => 'sometimes|string|in:male,female',
            'subscription_date' => 'nullable|date',
            'rate' => 'sometimes|integer|max:5|min:1',
            'tags' => 'sometimes|array',
            'tags.*' => 'string'
        ];
    }
}
