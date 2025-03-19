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
            'salesmen_code' => 'required|string|exists:salesmens,code',
            'name' => 'required|string|unique:customers,name|max:255',
            'tel1' => 'required|string|max:12',
            'tel2' => 'nullable|string|max:12',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'subscription_date' => 'required|date',
            'rate' => 'required|integer|max:5|min:1',
            'photo'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
        ];
    }
}
