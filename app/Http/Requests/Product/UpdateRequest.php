<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
            'name' => 'nullable|sometimes|string|max:255',
            'price' => 'nullable|sometimes|numeric|min:0',
            'quantity' => 'nullable|sometimes|numeric|min:0',
            'image' => 'nullable|sometimes|image|mimes:jpg,jpeg,png',
            'factory_id' => 'nullable|sometimes|integer|exists:factory,id',
            'description' => 'nullable|sometimes|string|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'error' => $validator->errors()->first(),
        ], 422));
    }
}
