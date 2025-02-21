<?php

namespace App\Http\Requests\ItemRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code'=>'required | unique:items,code| max:25',
            'name'=>'required | string',
            'description'=>'string  | max:225 | nullable',
        ];
    } 

    public function messages()
    {
        return [
        'code.required' => 'code is required ape'
    ];
    }
}
