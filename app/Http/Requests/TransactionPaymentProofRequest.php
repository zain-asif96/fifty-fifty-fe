<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class TransactionPaymentProofRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'payment_proof_file' => ['required',
                File::types(['png', 'jpg', 'svg', 'pdf'])
                    ->min(1)
                    ->max(5 * 1024) // 5MB
            ],
            'transaction_id' => ['required', 'size:12', 'string'],
            'payment_intent_id' => ['nullable']
        ];
    }
}
