<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class BuyCoinRequest extends FormRequest
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
            'value' => ['required', 'numeric'],
            'gateway' => ['required', 'string'],
            'description' => ['string','nullable'],
        ];
    }
}
