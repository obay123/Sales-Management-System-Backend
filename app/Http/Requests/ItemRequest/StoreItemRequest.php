<?php

namespace App\Http\Requests\ItemRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'code'=>'required | unique:items,code| max:25',
            'name'=>'required | string|unique:items,name',
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
