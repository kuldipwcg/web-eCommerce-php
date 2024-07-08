<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordCheck extends FormRequest
{
    
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
            'currentPassword' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data'      => $validator->errors(),
            'Status'   => 'Invalid',
            'message'   => 'Invalid Input, Please enter valid input',
        ]));
    } 
    public function messages()
    {
        return [
            'currentPassword.required' => 'Current Password is required.',
            'password.required' => 'Password is required',
            'confirmPassword.required' => 'Confirm Password is required.',
            'confirmPassword.same' => 'Password and Confirm Password should be same.',
        ];
    }

}
