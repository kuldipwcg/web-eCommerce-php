<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishlistRequest extends FormRequest
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
            'user_id'=>'required',
            'product_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'user_id is required.',
            'product_id.required' => 'product_id is required.',
        ];
    }

}