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
        
        $files = File::files($this->templatesPath);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $name = $file->getBasename('.blade.php');
                $templates[] = [
                    'id' => $name,
                    'name' => ucfirst(str_replace('-', ' ', $name)),
                    'preview' => $this->getTemplatePreview($name),
                    'placeholders' => $this->extractPlaceholders($file->getPathname())
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
