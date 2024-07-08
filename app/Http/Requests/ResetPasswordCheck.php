<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class ResetPasswordCheck extends FormRequest
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
            
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
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
            'email.exists' => 'Email does not exist',
            'password.required' => 'Password is required',
            'password.min' => 'Password should contains minimum 6 characters',
            'confirmPassword.required' => 'confirmPassword is required',
            'confirmPassword.same'=> 'confirmPassword should be same as password',       
           
        ];
    }
}
