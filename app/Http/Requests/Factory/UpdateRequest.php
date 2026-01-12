<?php

namespace App\Http\Requests\Factory;

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
            'motto' => 'nullable|sometimes|string|max:255',
            'user_id' => 'nullable|sometimes|integer|exists:users,id',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'error' => $validator->errors()->toArray()
            ], 422));
    }

}
