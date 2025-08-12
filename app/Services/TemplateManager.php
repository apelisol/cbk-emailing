<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class TemplateManager
{
    protected $templatesPath;

    public function __construct()
    {
        $this->templatesPath = resource_path('views/email-templates/templates');
    }

    public function getAvailableTemplates(): Collection
    {
        $templates = [];
        
        // Add CBK Email Templates as a single template group
        $templates[] = [
            'id' => 'cbk-email-templates',
            'name' => 'CBK Email Templates',
            'preview' => 'Professional email templates for various banking communications',
            'placeholders' => [
                'customer_name', 'account_number', 'account_type', 'activation_link',
                'statement_period', 'opening_balance', 'closing_balance', 'statement_link',
                'transaction_type', 'amount', 'transaction_date', 'reference_number',
                'available_balance', 'dispute_link', 'loan_amount', 'loan_type',
                'interest_rate', 'loan_term', 'monthly_payment', 'loan_reference',
                'accept_loan_link', 'security_event', 'event_time', 'location',
                'ip_address', 'secure_account_link'
            ],
            'is_group' => true,
            'templates' => [
                [
                    'id' => 'welcome',
                    'name' => 'Welcome Email',
                    'preview' => 'Welcome new customers to your bank',
                    'placeholders' => ['customer_name', 'account_number', 'account_type', 'activation_link']
                ],
                [
                    'id' => 'statement',
                    'name' => 'Account Statement',
                    'preview' => 'Monthly account statement notification',
                    'placeholders' => ['customer_name', 'account_number', 'statement_period', 'opening_balance', 'closing_balance', 'statement_link']
                ],
                [
                    'id' => 'transaction',
                    'name' => 'Transaction Alert',
                    'preview' => 'Real-time transaction notifications',
                    'placeholders' => ['customer_name', 'transaction_type', 'amount', 'transaction_date', 'reference_number', 'available_balance', 'dispute_link']
                ],
                [
                    'id' => 'loan',
                    'name' => 'Loan Approval',
                    'preview' => 'Loan approval and details',
                    'placeholders' => ['customer_name', 'loan_amount', 'loan_type', 'interest_rate', 'loan_term', 'monthly_payment', 'loan_reference', 'accept_loan_link']
                ],
                [
                    'id' => 'security',
                    'name' => 'Security Notice',
                    'preview' => 'Important security alerts',
                    'placeholders' => ['customer_name', 'security_event', 'event_time', 'location', 'ip_address', 'secure_account_link']
                ]
            ]
        ];
        
        // Add individual template files from the templates directory
        $files = File::files($this->templatesPath);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && $file->getBasename('.blade.php') !== 'cbk-email-templates') {
                $name = $file->getBasename('.blade.php');
                $templates[] = [
                    'id' => $name,
                    'name' => ucfirst(str_replace('-', ' ', $name)),
                    'preview' => $this->getTemplatePreview($name),
                    'placeholders' => $this->extractPlaceholders($file->getPathname()),
                    'is_group' => false
                ];
            }
        }
        
        return collect($templates);
    }

    protected function getTemplatePreview(string $templateName): string
    {
        // Simple preview text (in a real app, you might generate a thumbnail)
        return "Preview of " . ucfirst(str_replace('-', ' ', $templateName));
    }

    protected function extractPlaceholders(string $filePath): array
    {
        $content = File::get($filePath);
        preg_match_all('/\{\{\s*\$([a-zA-Z_]+)\s*\}\}/', $content, $matches);
        return array_unique($matches[1] ?? []);
    }

    public function getTemplateContent(string $templateName, array $data = []): string
    {
        $view = "email-templates.templates.{$templateName}";
        
        if (!view()->exists($view)) {
            throw new \Exception("Template {$templateName} not found");
        }
        
        return view($view, $data)->render();
    }
}
