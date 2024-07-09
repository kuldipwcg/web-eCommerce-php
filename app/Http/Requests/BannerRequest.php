<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BannerRequest extends FormRequest
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
            "banner_image"=>"mimes:jpeg,jpg,png,gif",
            "banner_title" => "required",
            "banner_desc" => "required",
            "banner_link" => "required|url",
        ];
    }

    public function messages(): array
    {
        return [
            "banner_title.required" => "Banner Title field required",
            "banner_desc.required" => "Banner Description field required",
            "banner_link.required" => "Banner Link field required",
            "banner_link.url"=> "Enter valid URL",
            "banner_image.mimes"=>"banner image must be in jpeg, jpg, png or gif",
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
