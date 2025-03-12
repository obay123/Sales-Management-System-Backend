<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'tel1' => 'required|string|max:12', 
            'tel2' => 'sometimes|string|max:12',
            'photo'=> 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'sometimes|string',
            'gender' => 'sometimes|string|in:male,female',
            'subscription_date' => 'nullable|date',
            'rate' => 'sometimes|integer|max:5|min:1',
            'tags' => 'sometimes|array',
            'tags.*' => 'string'
        ];
    }
}
