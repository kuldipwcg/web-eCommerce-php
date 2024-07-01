<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
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
            
            'category_name'=>'required|min:3|max:25',
            'sub_categories_id'	=>'required',
            'image'=>"required|mimes:jpeg,jpg,png",
            'status'=>'required',
            
        ];

    }
    public function messages()
{
    return [
        'category_name.required' => 'category_name is required.',
        'sub_categories_id.required' => 'sub_categories_id is required.',
        'image.required' => "image should be in jpeg,jpg or png",
        'status' => 'status is required.',
       
    ];
}

public function failedValidation(Validator $validate){
    throw new HttpResponseException(response()->json([
        'success'=>false,
        'message' => 'validation error',
        'data' => $validate->errors()
    ]));
}
}
