<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PaymentRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string',
            'transaction_status' => 'required|string',
            'payment_date' => 'required|date',
        ];    
    }
    public function messages()
    {
        return [
            'order_id.required' => 'order_id is required.',
            'payment_method.required' => 'payment_method is required.',
            'amount.required' => 'amount is required.',
            'transaction_id.required' => 'transaction_id is required.', 
            'transaction_status.required' => 'transaction_status is required.',
            'payment_date.required' => 'date is required'
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