<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        //
        'firstName'=>'required|max:15',
        'lastName'=>'required|max:15',
        'email'=>'required|email|unique:users,email',
        'phoneNo'=>'required|digits:10',
        'dob'=>'required',
        // 'image'=> 'required|mimes:jpeg,jpg,png|max:5000',
    ];
    
}

    public function failedValidation(Validator $validate){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'message' => 'validation error',
            'data' => $validate->errors()
        ]));
    }

public function messages()
{
    return [
        'firstName.required' => 'firstName is required.',
        'lastName.required' => 'It is mandatory to fill lastName.',
        'email.required' => 'It is mandatory to fill email field.',
        'phoneNo.required' => 'It is mandatory to fill phoneNo field.',
        'dob.required'=>'It is mandatory to fill Dob field.',
        // 'image.required'=>'please fill image field.'
    ];
}
}
