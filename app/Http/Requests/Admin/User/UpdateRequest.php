<?php

namespace App\Http\Requests\Admin\User;

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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'avatar' => 'file|max:512',
            'coin' => ['numeric'],
            'score' => ['numeric'],
            'phone' => 'required|digits:11|numeric',
            'superuser' => ['required', 'in:1,0'],
        ];
    }
}
