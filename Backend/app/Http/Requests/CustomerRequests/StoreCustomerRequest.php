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
            'tel1' => 'string|nullable|max:12',
            'tel2' => 'nullable|string|max:12',
            'photo'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female',
            'subscription_date' => 'nullable|date',
            'rate' => 'nullable|integer|max:5|min:1',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ];
    }
}
