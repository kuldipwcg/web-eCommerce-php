<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required|unique:categories,category_name',
            'image' => 'required',
            'status' => 'required',
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
            'category_name.required' => 'category_name is required.',
            'image.required' => 'image is required',
            'status' => 'status is required.',
        ];
    }

}
