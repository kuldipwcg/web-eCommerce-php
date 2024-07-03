<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class SubCategoryRequest extends FormRequest
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
            'category_id'=>'required',
            'category_name'=>'required|min:3|max:25'
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'category_id is required.',
            'category_name.required' => 'category_name is required.',
            'category_name.min' => 'please enter atleast 3 characters.',
            'category_name.max' => 'category_type must not exceed 25 characters.',
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
