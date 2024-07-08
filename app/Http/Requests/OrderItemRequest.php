<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class OrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required', //required|exists:orders,id',
            'product_id' => 'required', //required|exists:products,id',
            'quantity' => 'required',
            'unit_price' => 'required|numeric|min:0',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'user_id is required.',
            'product_id.required' => 'product_id is required.',
            'quantity.required' => 'quantity is required.',
            'total.required' => 'total is required.',
            'unit_price.required' => 'unit_price is required.',
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
