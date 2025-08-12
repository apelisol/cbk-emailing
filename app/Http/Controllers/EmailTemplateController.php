<?php
namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = auth()->user()->emailTemplates()->latest()->paginate(15);
        return view('email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('email-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Extract placeholders from subject and body
        $placeholders = $this->extractPlaceholders($request->subject . ' ' . $request->body);

        auth()->user()->emailTemplates()->create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'placeholders' => $placeholders,
        ]);

        return redirect()->route('email-templates.index')
            ->with('success', 'Email template created successfully.');
    }

    public function show(EmailTemplate $emailTemplate)
    {
        $this->authorize('view', $emailTemplate);
        return view('email-templates.show', compact('emailTemplate'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        $this->authorize('update', $emailTemplate);
        return view('email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $this->authorize('update', $emailTemplate);

        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $placeholders = $this->extractPlaceholders($request->subject . ' ' . $request->body);

        $emailTemplate->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'placeholders' => $placeholders,
        ]);

        return redirect()->route('email-templates.index')
            ->with('success', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $this->authorize('delete', $emailTemplate);
        
        $emailTemplate->delete();

        return redirect()->route('email-templates.index')
            ->with('success', 'Email template deleted successfully.');
    }

    private function extractPlaceholders(string $text): array
    {
        preg_match_all('/\{\{(\w+)\}\}/', $text, $matches);
        return array_unique($matches[1]);
    }
}