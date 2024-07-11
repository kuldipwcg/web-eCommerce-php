<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class ReviewRequest extends FormRequest
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
            'product_id'=>'required|exists:products,id',
            'rating' => 'required|min:1|max:5',
            'review' =>'required|string|min:4|max:255'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],422));
    } 

    public function messages()
    {
        return [
            'product_id.required' => 'The product id is Required.',
            'product_id.exists' => 'The selected product id does not exist.',
            'rating.required'=> 'The rating is Required.',
            'rating.min'=> 'The rating value must be at least 1.',
            'rating.max' =>'The rating value must be less than or equals 5.',
            'review.required'=> 'The review is Required.',
            'review.string'=>'The review type must be a string.',
            'review.min'=> 'The review length must be at least 4 characters.',
            'review.max' =>'The review length must be less than or equals 255 characters.',
        ];
    }
}
