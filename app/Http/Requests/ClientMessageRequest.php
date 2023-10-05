<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientMessageRequest extends FormRequest
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
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:300',
            'postal_code' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:100',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }
}
