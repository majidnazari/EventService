<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /* it cn be a custome file for validation and also cutome rule but here a simple rules applyed */
        return [
            'user_id' => ['required', 'integer'],
            'event_name' => ['required', 'string', 'max:255'],
            'payload_version' => ['nullable', 'integer'], // the version help us to fetch by a category and doean't change all of old payload
            'payload' => ['nullable', 'array'], // it is json and mybe null 
        ];
    }
}
