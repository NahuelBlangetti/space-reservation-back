<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SymbolRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'symbol' => 'required|string|max:10',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'symbol.required' => 'The symbol is required',
            'symbol.string' => 'The symbol must be a string',
            'symbol.max' => 'The symbol must be less than 10 characters',
        ];
    }
}
