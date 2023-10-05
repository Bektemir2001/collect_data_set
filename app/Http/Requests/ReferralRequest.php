<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferralRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'practice_name' => 'required|string',
            'dentist_name' => 'required|string',
            'title' => 'nullable|string',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|string|max:200',
            'date_of_birth' => 'required|string|max:200',
            'country' => 'nullable|string|max:200',
            'address1' => 'required|string|max:300',
            'address2' => 'nullable|string|max:300',
            'postal_code' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'post_code' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'reason_for_referral' => 'nullable',
            'oral_surgery' => 'nullable',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }
}
