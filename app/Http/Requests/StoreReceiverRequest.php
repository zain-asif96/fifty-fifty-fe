<?php

namespace App\Http\Requests;

use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreReceiverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !!auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255', 'min:2', 'string'],
            'last_name' => ['required', 'max:255', 'min:2', 'string'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'country' => ['required', 'max:255', 'min:2', 'string'],
            'bank_id' => ['required', 'max:255'],
            'account_number' => ['required', 'max:255', 'min:3', 'string'],
            'branch_number' => ['nullable', 'max:255', 'string'],
            'paymentIntentId' => ['required', 'max:191', 'string'],
            'banking_info' => ['nullable', 'max:2500', 'string'],
        ];
    }
}
