<?php

namespace App\Http\Requests\Admin\Package;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'image' => 'file|max:512',
            'description' => 'string',
            'activation' => 'date',
            'deactivation' => 'date',
            'coins' => ['required','numeric'],
            'count' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'counted_price' => ['required', 'numeric'],
        ];
    }
}
