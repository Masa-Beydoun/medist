<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineStoreRequest extends FormRequest
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
            'commercial_name' => 'required|max:255|min:4',
            'scientific_name' => 'required|max:255|min:4',
            'description' => 'required|max:255|min:4',
            'category_id' => 'required',
            'company_id' => 'required',
            'image' => 'required'
        ];
    }
}
