<?php

namespace App\Http\Requests\Admin\Setting;

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
            'create_public_room_cost' => ['required', 'numeric'],
            'create_private_room_cost' => ['required', 'numeric'],
            'default_score' => ['required', 'numeric'],
            'default_coin' => ['required', 'numeric'],
            'coin_price' => ['required', 'numeric'],
            'special_link_cost' => ['required', 'numeric'],
            'private_join_cost' => ['required', 'numeric'],
            'public_join_cost' => ['required', 'numeric'],
        ];
    }
}
