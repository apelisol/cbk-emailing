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

    /**
     * Preview a template with sample data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function previewTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|string',
            'content' => 'nullable|string',
            'subject' => 'nullable|string',
        ]);

        try {
            $templateId = $request->template;
            $template = null;
            $isCbkTemplate = false;
            $templateName = null;

            // Check if this is a CBK template
            if (strpos($templateId, 'cbk-email-templates.') === 0) {
                $isCbkTemplate = true;
                $templateName = str_replace('cbk-email-templates.', '', $templateId);
                
                // Get the specific CBK template
                $allTemplates = $this->templateManager->getAvailableTemplates();
                $cbkTemplateGroup = $allTemplates->firstWhere('id', 'cbk-email-templates');
                
                if ($cbkTemplateGroup && isset($cbkTemplateGroup['templates'])) {
                    $template = collect($cbkTemplateGroup['templates'])->firstWhere('id', $templateName);
                }
            } else {
                // Handle custom templates
                $allTemplates = $this->templateManager->getAvailableTemplates();
                $template = $allTemplates->firstWhere('id', $templateId);
            }

            // If template not found in available templates, use the provided content
            $content = $request->content;
            $subject = $request->subject ?? 'Preview Email';
            $placeholders = [];

            if ($template) {
                // Use template's default content if no custom content provided
                if (empty($content) && !empty($template['default_content'])) {
                    $content = $template['default_content'];
                }
                
                // Get placeholders from template or extract from content
                $placeholders = $template['placeholders'] ?? $this->extractPlaceholders($content);
            } else {
                // Extract placeholders from the provided content
                $placeholders = $this->extractPlaceholders($content . ' ' . $subject);
            }

            // Generate sample data for placeholders
            $sampleData = [];
            foreach ($placeholders as $placeholder) {
                // Create more realistic sample data based on placeholder name
                $sampleData[$placeholder] = $this->generateSampleData($placeholder);
            }

            // If this is a CBK template, use the template's view
            if ($isCbkTemplate && $template) {
                $view = 'email-templates.templates.cbk-email-templates';
                
                // Render the template with sample data
                $preview = view($view, [
                    'template' => $templateName,
                    'data' => $sampleData,
                    'isPreview' => true
                ])->render();
            } else {
                // For custom templates or when using provided content
                $preview = $this->renderCustomTemplate($content, $sampleData);
            }

            return response()->json([
                'preview' => $preview,
                'placeholders' => $placeholders,
                'subject' => $this->replacePlaceholders($subject, $sampleData)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error generating template preview: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate preview. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Generate sample data for a placeholder
     *
     * @param  string  $placeholder
     * @return string
     */
    protected function generateSampleData($placeholder)
    {
        // Map common placeholder patterns to sample data
        $sampleData = [
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '(555) 123-4567',
            'date' => now()->format('F j, Y'),
            'amount' => '$1,234.56',
            'account_number' => 'XXXX-XXXX-7890',
            'transaction_id' => 'TXN-' . rand(100000, 999999),
            'link' => url('/activate-account?token=abc123'),
            'expiry_date' => now()->addDays(7)->format('F j, Y'),
            'company' => 'Your Company Name',
            'address' => '123 Business St.\nNew York, NY 10001',
            'website' => 'www.yourcompany.com',
            'support_email' => 'support@yourcompany.com',
            'support_phone' => '1-800-123-4567',
        ];

        // Check for matches in the placeholder name
        $placeholder = strtolower($placeholder);
        
        foreach ($sampleData as $key => $value) {
            if (strpos($placeholder, $key) !== false) {
                return $value;
            }
        }

        // Default sample data
        return 'Sample ' . str_replace('_', ' ', $placeholder);
    }

    /**
     * Replace placeholders in a string with their values
     *
     * @param  string  $content
     * @param  array  $data
     * @return string
     */
    protected function replacePlaceholders($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
            $content = str_replace('{{ $' . $key . ' }}', $value, $content);
        }
        
        return $content;
    }

    /**
     * Render a custom template with the given data
     *
     * @param  string  $content
     * @param  array  $data
     * @return string
     */
    protected function renderCustomTemplate($content, $data)
    {
        // Replace placeholders in the content
        $rendered = $this->replacePlaceholders($content, $data);
        
        // Wrap in a basic email template if it doesn't look like a full HTML document
        if (!preg_match('/<html|<body|<head/i', $rendered)) {
            $rendered = view('emails.template', [
                'content' => $rendered,
                'data' => $data
            ])->render();
        }
        
        return $rendered;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'selected_template' => 'required|string',
        ]);

        // Extract placeholders from content and subject
        $content = $request->content;
        $subject = $request->subject;
        
        // Unescape Blade syntax in content (we escaped it in the frontend to prevent PHP errors)
        $content = str_replace('@{{', '{{', $content);
        $content = str_replace('}}', '}}', $content);
        
        // Extract placeholders from both subject and content
        $placeholders = array_unique(array_merge(
            $this->extractPlaceholders($subject),
            $this->extractPlaceholders($content)
        ));
        
        // Get the template ID and type
        $templateId = $request->selected_template;
        $templateType = null;
        
        // Check if this is a CBK template (format: cbk-email-templates.template_name)
        if (strpos($templateId, 'cbk-email-templates.') === 0) {
            $templateType = 'cbk-email-templates';
            $templateName = str_replace('cbk-email-templates.', '', $templateId);
        } else {
            $templateType = 'custom';
            $templateName = $templateId;
        }

        // Create the email template
        $template = auth()->user()->emailTemplates()->create([
            'name' => $request->name,
            'subject' => $subject,
            'body' => $content,
            'placeholders' => $placeholders,
            'template_type' => $templateType,
            'template_name' => $templateName,
        ]);

        return redirect()->route('email-templates.show', $template)
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