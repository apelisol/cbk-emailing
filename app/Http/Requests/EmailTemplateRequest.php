<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Template name is required.',
            'subject.required' => 'Email subject is required.',
            'body.required' => 'Email body is required.',
        ];
    }
}
