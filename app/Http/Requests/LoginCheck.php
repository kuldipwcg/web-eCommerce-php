<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginCheck extends FormRequest
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
            
            'email' => 'required|unique:email|max:50',
            'password' => 'required|min:6',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    } 

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.unique' => 'Email should be unique',
            'email.max' => 'Email should be maximum of 50 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password should contain minimum 6 character',
        ];
    }
}
