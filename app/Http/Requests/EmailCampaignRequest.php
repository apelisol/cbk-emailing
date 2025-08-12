<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:template,custom',
            'template_id' => 'required_if:type,template|exists:email_templates,id',
            'custom_subject' => 'required_if:type,custom|string|max:255',
            'custom_body' => 'required_if:type,custom|string',
            'recipient_ids' => 'required|array|min:1',
            'recipient_ids.*' => 'exists:clients,id',
            'scheduled_at' => 'required|date|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please select a campaign type.',
            'template_id.required_if' => 'Please select a template.',
            'custom_subject.required_if' => 'Subject is required for custom campaigns.',
            'custom_body.required_if' => 'Email body is required for custom campaigns.',
            'recipient_ids.required' => 'Please select at least one recipient.',
            'recipient_ids.min' => 'Please select at least one recipient.',
            'scheduled_at.required' => 'Please select a send time.',
            'scheduled_at.after' => 'Send time must be in the future.',
        ];
    }
}
