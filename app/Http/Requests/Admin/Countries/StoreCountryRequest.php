<?php

namespace App\Http\Requests\Admin\Countries;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('super.admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'label' => ['required', 'min:3', 'max:199', 'string'],
            'code' => ['required', 'min:3', 'max:3', 'string', 'unique:countries'],
            'code_iso_2' => ['required', 'min:2', 'max:2', 'string', 'unique:countries'],
            'can_send' => ['required', 'min:1', 'max:1', 'string'],
            'can_receive' => ['required', 'min:1', 'max:1', 'string'],
            'currency_id' => ['required', 'numeric'],

            'tel_code' => ['nullable', 'min:2', 'max:199', 'string'],
            'continent' => ['nullable', 'min:2', 'max:199', 'string'],
            'area' => ['nullable', 'min:2', 'max:199', 'string'],
            'population' => ['nullable', 'min:1', 'max:199', 'string'],
        ];
    }
}
