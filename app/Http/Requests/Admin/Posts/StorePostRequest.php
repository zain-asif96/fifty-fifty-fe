<?php

namespace App\Http\Requests\Admin\Posts;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'string','exists:currencies,code'],
            'status' => ['required', 'string', 'in:' . implode(',', Post::STATUSES())],
            'receiver_id' => ['required', 'numeric', 'exists:receivers,id'],
            'country_code' => ['required', 'string', 'exists:countries,code_iso_2'],
        ];
    }
}
