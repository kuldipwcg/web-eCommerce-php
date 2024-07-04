<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class OrderRequest extends FormRequest
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
            'user_id' => 'required',
            'cart_id' => 'required',
            'order_date' => 'required',
            'status' => 'required',
            'total' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'user_id is required.',
            'cart_id.required' => 'cart_id is required.',
            'order_date.required' => 'order_date is required.',
            'status.required' => 'please fill this field.',
            'total.required' => 'please enter the total amount.',
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
