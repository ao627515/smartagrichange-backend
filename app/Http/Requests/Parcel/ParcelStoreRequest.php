<?php

namespace App\Http\Requests\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class ParcelStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'area' => 'required|numeric|min:0',
            'field_id' => 'required|exists:fields,id',
        ];
    }
}