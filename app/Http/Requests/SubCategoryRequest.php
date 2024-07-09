<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
         
            'subcategory_name' => 'required|min:3|max:25',
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'category_id is required.',
            'subcategory_name.required' => 'category_name is required.',
            'subcategory_name.min' => 'please enter atleast 3 characters.',
            'subcategory_name.max' => 'category_name must not exceed 25 characters.',
        ];
    }
}
