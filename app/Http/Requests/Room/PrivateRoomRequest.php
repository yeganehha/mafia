<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class PrivateRoomRequest extends FormRequest
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
            'type' => ['required', 'in:classic'],
            'password' => ['string'],
            'customLink' => ['string'],
            'joinRequest' => ['boolean'],
        ];
    }
}
