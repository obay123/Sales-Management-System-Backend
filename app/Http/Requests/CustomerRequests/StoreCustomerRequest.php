<?php

namespace App\Http\Requests\CustomerRequests;
use Illuminate\Foundation\Http\FormRequest;


class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:customers,name',
            'salesmen_code' => 'required|string|exists:salesmens,code',
            'tel1' => 'string|required|max:12',
            'tel2' => 'nullable|string|max:12',
            'address' => 'nullable|string',
            'gender' => 'required|string|in:male,female',
            'subscription_date' => 'nullable|date',
            'rate' => 'required|integer|max:5|min:1',
            'tags' => 'required|array',
            'tags.*' => 'string',
           
        ];
    }
}
