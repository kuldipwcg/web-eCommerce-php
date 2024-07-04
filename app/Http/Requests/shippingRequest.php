<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class shippingRequest extends FormRequest
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
                'firstName' => 'required|string|max:20',
                'lastName' => 'required|string|max:20',
                'email' => 'required|email',
                'mobileNumber' => 'required|integer|digits:10',
                'address1' => 'required|string',
                'address2' => 'nullable|string',
                'zipCode' => 'required|integer|digits:6',
                'country' => 'required|string|max:10',
                'state' => 'required|string|max:10',
                'city' => 'required|string|max:10',
                'shippingCost' => 'required|numeric|between:0,500',
            ];
            if ($this->input('ship_to_different')) {
                $rules['shipping_address1'] = 'required|string';
                $rules['shipping_address2'] = 'nullable|string';
                $rules['shipping_zipCode'] = 'required|integer|digits:6';
                $rules['shipping_country'] = 'required|string|max:10';
                $rules['shipping_state'] = 'required|string|max:10';
                $rules['shipping_city'] = 'required|string|max:10';
            }
    
        
    }
    public function messages()
    {
        return [
            "firstName.required" => "firstName is required",
            "lastName.required"=> "lastname is required",
            "email.required" => "email is required",
            "mobileNumber.required" => "mobileNumber is required",
            "address1.required" => "address1 is required",
            "address2.required"=> "address2 is required",
            "zipCode.required"=>"zipcode is required",
            "country.required" => "country is required",
            "state.required" => "state is required",
            "city.required" => "city is required",
            "shippingCost.required" => "shippingCost is required",
           
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}