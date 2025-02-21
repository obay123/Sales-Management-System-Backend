<?php

namespace App\Http\Requests\SalesmenRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesmenRequest extends FormRequest
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
            'code'=>'unique:salesmens,code|required|string|max:10',
            'name'=>'required|string',
            'phone'=>'required|max:12|string',
            'address'=>'nullable|string|max:225',
            'is_inactive'=>'required'|'boolean'
        ];
    }
}
