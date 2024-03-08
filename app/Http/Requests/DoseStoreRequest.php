<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'dose' => 'required|string|max:8',
            'type' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'expiry_date' => 'required|date',
        ];
    }
}
