<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class cartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            // 'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|integer',
            // 'order_placed' => 'boolean',
        ];
    }
    public function messages()
    {
        return [
            // 'user_id.required' => 'user_id is required.',
            // 'product_id' => 'required|exists:products,id',
            'product_id.required' => 'product_id is required.',
            // 'quantity.required' => 'quantity is required.',
            'quantity' => 'required|integer|max:2',
        ];
           
          
        
    }
    public function failedValidation(Validator $validate)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'validation error',
                'data' => $validate->errors(),
            ]),
        );
    }
}
