<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Contracts\Validation\Validator;

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
            'category_name' => 'required|min:3|max:25',
           
            'image' => 'required|mimes:jpeg,jpg,png',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'category_name.required' => 'category_name is required.',
           
            'image.required' => 'image should be in jpeg,jpg or png',
            'status' => 'status is required.',
        ];
    }

}
