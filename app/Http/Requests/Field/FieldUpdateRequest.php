<?php

namespace App\Http\Requests\Field;

use App\Http\Requests\Traits\RequestFailedMethodesTrait;
use Illuminate\Foundation\Http\FormRequest;

class FieldUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }
}
