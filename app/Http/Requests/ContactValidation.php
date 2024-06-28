<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|unique:contacts,email|max:50',
            'message' => 'required',
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
            'name.required' => 'Email is required',
            'subject.required' => 'description is required',
            'email.required' => 'Email is required',
            'message.required' => 'phone is required',
        ];
    }
}
