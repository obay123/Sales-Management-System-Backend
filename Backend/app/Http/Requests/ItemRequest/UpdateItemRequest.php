<?php

namespace App\Http\Requests\ItemRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|max:5',
            'name' => [
                'sometimes',
                'string',
                Rule::unique('items', 'name')->ignore($this->route('item')->code, 'code'),
            ],
            'description' => 'sometimes | string | max:225 | nullable',
        ];
    }
}
