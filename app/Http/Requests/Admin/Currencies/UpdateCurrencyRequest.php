<?php

namespace App\Http\Requests\Admin\Currencies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('super.admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => ['nullable', 'min:3', 'max:3', 'string'],
            'name' => ['nullable', 'min:3', 'max:199', 'string'],
            'rate_source' => ['nullable', 'min:3', 'max:199', 'string'],
            'rate' => ['nullable', 'numeric'],
            'special_rate' => ['nullable', 'numeric'],
        ];
    }
}
