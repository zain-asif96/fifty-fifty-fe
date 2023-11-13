<?php

namespace App\Http\Requests\Admin\Posts;

use App\Models\Post;
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
            'status' => ['required', 'string', 'in:' . implode(',', Post::STATUSES())],
            'amount' => ['required', 'numeric'],
        ];
    }
}
