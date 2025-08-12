<?php
namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Services\TemplateManager;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    protected $templateManager;

    public function __construct(TemplateManager $templateManager)
    {
        $this->templateManager = $templateManager;
    }

    public function index()
    {
        $templates = auth()->user()->emailTemplates()->latest()->paginate(15);
        return view('email-templates.index', compact('templates'));
    }

    public function create()
    {
        $templates = $this->templateManager->getAvailableTemplates();
        return view('email-templates.create', compact('templates'));
    }

    public function previewTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|string',
        ]);

        try {
            $template = $this->templateManager->getAvailableTemplates()
                ->firstWhere('id', $request->template);

            if (!$template) {
                return response()->json(['error' => 'Template not found'], 404);
            }

            // Generate preview with sample data
            $sampleData = array_fill_keys($template['placeholders'], 'Sample Data');
            $preview = $this->templateManager->getTemplateContent($request->template, $sampleData);

            return response()->json([
                'preview' => $preview,
                'placeholders' => $template['placeholders']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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