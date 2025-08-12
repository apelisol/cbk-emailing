<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id;
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $clientId,
            'phone' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Client name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}