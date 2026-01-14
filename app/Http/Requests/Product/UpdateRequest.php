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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|sometimes|required|string|max:255',
            'price' => 'nullable|sometimes|required|numeric|min:0',
            'quantity' => 'nullable|sometimes|required|numeric|min:0',
            'image' => 'nullable|sometimes|required|image|mimes:jpg,jpeg,png',
            'factory_id' => 'nullable|sometimes|required|integer|exists:factory,id',
            'description' => 'nullable|sometimes|required|string|max:255',
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
