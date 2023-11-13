<?php

namespace App\Http\Requests\Admin\Currencies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCurrencyRequest extends FormRequest
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
            'code' => ['required', 'min:3', 'max:3', 'string',  Rule::unique('currencies')->ignore($this->id)],
            'name' => ['required', 'min:3', 'max:199', 'string'],
            'rate_source' => ['required', 'min:3', 'max:199', 'string'],
            'rate' => ['required', 'numeric'],
            'special_rate' => ['required', 'numeric'],
        ];
    }
}
