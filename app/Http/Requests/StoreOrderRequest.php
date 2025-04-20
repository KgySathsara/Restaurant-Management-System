<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'concessions' => 'required|array',
            'concessions.*' => 'exists:concessions,id',
            'send_to_kitchen_time' => 'required|date|after_or_equal:now',
        ];
    }
}
