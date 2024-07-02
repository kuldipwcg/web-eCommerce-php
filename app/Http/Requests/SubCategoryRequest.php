<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Contracts\Validation\Validator;
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
            // 'product_id'=>'required',
            'subcategory_name'=>'required|min:3|max:25'
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'category_id is required.',
            // 'product_id.required' => 'product_id is required.',
            'subcategory_name.required' => 'category_name is required.',
            'subcategory_name.min' => 'please enter atleast 3 characters.',
            'subcategory_name.max' => 'category_name must not exceed 25 characters.',
        ];
    }

  
}
