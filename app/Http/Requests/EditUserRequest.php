<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            "lastname" => 'required',
            "firstname" => 'required',
            "middle_name" => 'required',
            "position" => 'required',
            "email" => 'required',
            "contact_number" =>  'required',
            "username" =>  'required',
            "profile_image" =>  'nullable|mimes:png,jpg',
            "department_id" => 'nullable'
        ];
    }
}
