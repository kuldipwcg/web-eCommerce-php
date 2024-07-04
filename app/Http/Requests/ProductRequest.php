<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'short_desc' => 'required|string',
            'description' => 'required|string',
            'information' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_name' => 'required|string|exists:categories,category_name',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric|min:0|lte:price',
            'variants' => 'required|array',
            'variants.*.color' => 'required|string|exists:product_colors,color',
            'variants.*.size' => 'required|string|exists:product_sizes,size',
            'variants.*.quantity' => 'required|integer|min:0',
            'image' => 'required|array',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'The product name is required.',
            'short_desc.required' => 'The short description is required.',
            'description.required' => 'The description is required.',
            'information.required' => 'The information is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'category_name.required' => 'The category name is required.',
            'category_name.exists' => 'The selected category name does not exist.',
            'discount_type.string' => 'The discount type must be a string.',
            'discount_value.numeric' => 'The discount value must be a number.',
            'discount_value.min' => 'The discount value must be at least 0.',
            'discount_value.lte' => 'The discount value must be less than or equal to the price.',
            'variants.required' => 'At least one variant is required.',
            'variants.*.color.required' => 'The color is required for each variant.',
            'variants.*.color.exists' => 'The selected color does not exist.',
            'variants.*.size.required' => 'The size is required for each variant.',
            'variants.*.size.exists' => 'The selected size does not exist.',
            'variants.*.quantity.required' => 'The quantity is required for each variant.',
            'variants.*.quantity.integer' => 'The quantity must be an integer.',
            'variants.*.quantity.min' => 'The quantity must be at least 0.',
            'image.required' => 'At least one image is required.',
            'image.*.image' => 'Each file must be an image.',
            'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif.',
            'image.*.max' => 'Each image may not be greater than 2048 kilobytes.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],403));
    }
}
