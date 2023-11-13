<?php

namespace App\Http\Requests\Admin\Commission;

use App\Models\Post;
use App\Rules\ValidateRowRanges;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'from' => ['required', 'numeric', new ValidateRowRanges()],
            'to' => ['required', 'numeric', new ValidateRowRanges()],
            'amount' => ['required', 'numeric'],
        ];
    }
}
