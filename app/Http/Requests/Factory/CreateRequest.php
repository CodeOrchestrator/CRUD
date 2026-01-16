<?php

namespace App\Http\Requests\Factory;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
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
            'name' => 'required|unique:factories,name|max:50|string',
            'motto' => 'required|string|max:255|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'user_id' => 'nullable|integer|exists:users,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {


        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'error' => $validator->errors()->toArray(),
            ],422)
        );
    }


}
