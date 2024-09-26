<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyRequest extends FormRequest
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
            'supply_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'image_url' => 'required|mimes:png,jpg',
        ];
    }

    public function messages(){
        return [
            'supply_name.required' => 'Please Enter Supply Name',
            'category_id.required' => 'Please Select Category',
            'description.required' => 'Please Enter Supply Description',
            'unit.required' => 'Select Unit',
            'image_url.required' => 'Image Field Is required!',
        ];
    }
}
