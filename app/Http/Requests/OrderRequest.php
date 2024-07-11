<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class OrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'total' => 'required|numeric',
            'billingAddress' => 'required|array',
            'billingAddress.firstName' => 'required|string',
            'billingAddress.lastName' => 'required|string',
            'billingAddress.email' => 'required|email',
            'billingAddress.mobileNumber' => 'required|numeric|digits:10',
            'billingAddress.address1' => 'required|string',
            'billingAddress.address2' => 'required|string',
            'billingAddress.zipCode' => 'required|numeric|digits:6',
            'billingAddress.country' => 'required|string',
            'billingAddress.state' => 'required|string',
            'billingAddress.city' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'total.required' => 'The total amount is required.',
            'billingAddress.address' => 'The billing address is required.',
            'billingAddress.firstName.required' => 'The first name is required.',
            'billingAddress.firstName.string' => 'The first name must be a string.',
            'billingAddress.lastName.required' => 'The last name is required.',
            'billingAddress.lastName.string' => 'The last name must be a string.',
            'billingAddress.email.required' => 'The email is required.',
            'billingAddress.email.email' => "The email is invalid format.",
            'billingAddress.mobileNumber.required' => 'The mobile number is required.',
            'billingAddress.address1.required' => 'The address line1 is required.',
            'billingAddress.address1.string' => 'The address line1 must be a string.',
            'billingAddress.address2.required' => 'The address line2 is required.',
            'billingAddress.address2.string' => 'The address line2 must be a string.',
            'billingAddress.zipCode.required' => 'The zipCode is required.',
            'billingAddress.country.required' => 'The country is required.',
            'billingAddress.country.string' => 'The state must be a string.',
            'billingAddress.state.required' => 'The state is required.',
            'billingAddress.state.string' => 'The country must be a string.',
            'billingAddress.city.required' => 'The city is required.',
            'billingAddress.city.string' => 'The city must be a string.',
        ];
    }
    public function failedValidation(Validator $validate)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'validation error',
                'data' => $validate->errors(),
            ],422),
        );
    }
}
