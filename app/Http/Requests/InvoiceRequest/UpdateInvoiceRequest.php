<?php

namespace App\Http\Requests\InvoiceRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'customer_id' => 'sometimes|required|exists:customers,id',
            'items'       => 'sometimes|required|array|min:1',
            'items.*.item_code'  => 'sometimes|required|exists:items,code',
            'items.*.quantity'   => 'sometimes|required|integer|min:1',
            'items.*.unit_price' => 'sometimes|required|numeric|min:0'
        ];
    } 
}
