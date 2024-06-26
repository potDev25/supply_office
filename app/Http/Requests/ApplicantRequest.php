<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantRequest extends FormRequest
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
            "middlename" => 'required',
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
            "email" => 'required|unique:users,email',
            "contact_number" =>  'required',
            "username" =>  'required|unique:users,username',
            "password" =>  'required',
            "password_confirmation" =>  'required',
            "profile_image" =>  'required|mimes:png,jpg',
            "sanitary_permit" =>  'required|mimes:pdf',
            "barangay_clearance" =>  'required|mimes:pdf'
        ];
    }
}
