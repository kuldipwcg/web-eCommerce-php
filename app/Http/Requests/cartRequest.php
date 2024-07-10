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
            
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|exists:colors',
            'size' => 'nullable|exists:sizes',
            'variants_id' => 'nullable|exists:product_variants,id',
            'order_placed' => 'nullable|boolean',
        ];
    }
    public function messages()
    {
        return [
           
            'product_id.required' => 'Product ID is required.',
            'product_id.exists' => 'Invalid product ID.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least 1.',
            'color.exists' => 'Invalid color.',
            'size.exists' => 'Invalid size .',
            // 'variants_id.exists' => 'Invalid variant ID.',
            'order_placed.boolean' => 'Order placed must be a boolean value.',
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
