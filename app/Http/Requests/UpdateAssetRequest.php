<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'brand'       => ['sometimes', 'nullable', 'string', 'max:100'],
            'model'       => ['sometimes', 'nullable', 'string', 'max:100'],
            'series'      => ['sometimes', 'nullable', 'string', 'max:100'],
            'status'      => ['sometimes', 'required', 'string', Rule::in(['active', 'in_repair', 'in_disuse'])],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'location_id' => ['sometimes', 'nullable', 'integer', 'exists:locations,id'],
            'contact_id'  => ['sometimes', 'nullable', 'integer', 'exists:contacts,id'],
        ];
    }
}
