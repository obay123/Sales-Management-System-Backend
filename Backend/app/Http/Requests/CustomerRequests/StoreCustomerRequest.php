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
            'salesmens_code' => 'required|string|exists:salesmens,code',
            'name' => 'required|string|unique:customers,name',
            'tel1' => '|nullablestring|max:12',
            'tel2' => 'nullable|string|max:12',
            'address' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female',
            'subscription_date' => 'nullable|date',
            'rate' => 'nullable|integer|max:5|min:1',
            'photo'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ];
    }
}
