<?php

namespace App\Http\Requests\SalesmenRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesmenRequest extends FormRequest
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
            'code'=>'unique:salesmens,code|sometimes|string|max:10',
            'name'=>'sometimes|string',
            'phone'=>'sometimes|max:12|string',
            'address'=>'sometimes|nullable|string|max:225',
            'is_inactive'=>'sometimes'|'boolean'
        ];
    }
}
