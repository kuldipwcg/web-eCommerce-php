<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserCheck extends FormRequest
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
            'email' => 'email',
            'phoneNumber' => 'numeric|digits:10',
            'image' => 'mimes:png,jpg,jpeg'
        ];
    }


    public function messages(): array
    {
        return [
            "email.email"=> "Please enter valid email",
            "phoneNumber.numeric"=> "phoneNumber should numeric",
            "image.mimes"=> "Image must type of png, jpg and jpeg",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors(),
            'success' => false,
        ],422));
    }
}
