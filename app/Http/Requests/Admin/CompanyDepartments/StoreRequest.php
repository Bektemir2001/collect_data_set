<?php

namespace App\Http\Requests\Admin\CompanyDepartments;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'email' => 'required|unique:company_departments',
            'mobile' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'facebook_link' => 'nullable',
            'address' => 'nullable',
            'address_link' => 'nullable',
            'google_map' => 'nullable',
            'google_analitics' => 'nullable',
            'archive' => 'nullable|integer'
        ];
    }
}
