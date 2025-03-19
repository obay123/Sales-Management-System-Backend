<?php

namespace App\Http\Requests\InvoiceRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'        => 'required|exists:customers,id',
            'items'              => 'required|array|min:1',
            'items.*.item_code'  => 'required|exists:items,code',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:1',
            'date'               => 'sometimes|date|before_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'items.*.item_code.exists' => `The selected item does not exist.`,
        ];
    }
}
