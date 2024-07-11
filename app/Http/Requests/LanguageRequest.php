<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LanguageRequest extends FormRequest
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
            "name"=> "required|unique:languages,name",
            "code"=> "required|unique:languages,code",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required"=> "name field requuired",
            "name.unique"=> "this name is already exists",
            "code.required"=> "code field requuired",
            "code.unique"=> "this code is already exists",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => $validator->errors(),
            'message' => 'Validation errors',
            'success' => false,
        ],422));
    }
}
