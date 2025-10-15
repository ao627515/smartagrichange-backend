<?php

namespace App\Http\Requests\OTP;

use App\Http\Requests\Traits\RequestFailedMethodesTrait;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOptRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'otp_code' => ['required', 'string', Rule::exists('user_otps', 'otp_code')]
        ];
    }
}
