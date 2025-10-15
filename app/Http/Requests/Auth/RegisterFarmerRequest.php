<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\RequestFailedMethodesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterFarmerRequest extends FormRequest
{
    use RequestFailedMethodesTrait;

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
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'calling_code' => 'sometimes|string|max:10|exists:country_calling_codes,calling_code',

            // 'phone_number' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone_number')) {
            $this->merge([
                'phone_number' => preg_replace('/\s+/', '', $this->input('phone_number')),
            ]);
        }
    }

    public function passedValidation() {}
}
