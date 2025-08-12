<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Email Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Create New Email Template</h1>
                    
                    <form action="{{ route('email-templates.store') }}" method="POST" id="templateForm">
                        @csrf
                        
                        <!-- Template Selection -->
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Choose a Template</h2>
                            
                            <!-- Template Groups -->
                            @foreach($templates as $template)
                                @if(isset($template['is_group']) && $template['is_group'])
                                    <div class="mb-6">
                                        <h3 class="text-md font-medium text-gray-700 mb-3">{{ $template['name'] }}</h3>
                                        <p class="text-sm text-gray-500 mb-4">{{ $template['preview'] }}</p>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                            @foreach($template['templates'] as $subTemplate)
                                                <div class="template-card p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors" 
                                                     data-group="{{ $template['id'] }}" 
                                                     data-template-id="{{ $template['id'] }}.{{ $subTemplate['id'] }}"
                                                     data-placeholders="{{ json_encode($subTemplate['placeholders']) }}">
                                                    <div class="font-medium text-gray-900">{{ $subTemplate['name'] }}</div>
                                                    <div class="text-sm text-gray-500 mt-1">{{ $subTemplate['preview'] }}</div>
                                                    <div class="mt-2 flex flex-wrap gap-1">
                                                        @foreach($subTemplate['placeholders'] as $placeholder)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $placeholder }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="template-card p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors mb-4" 
                                         data-template-id="{{ $template['id'] }}"
                                         data-placeholders="{{ json_encode($template['placeholders']) }}">
                                        <div class="font-medium text-gray-900">{{ $template['name'] }}</div>
                                        <div class="text-sm text-gray-500 mt-1">{{ $template['preview'] }}</div>
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach($template['placeholders'] as $placeholder)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $placeholder }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            <input type="hidden" name="selected_template" id="selectedTemplate" value="">
                        </div>

                        <!-- Template Editor -->
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Template Editor</h2>
                            
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
                                <input type="text" name="name" id="templateName" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Enter template name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Email Subject</label>
                                <input type="text" name="subject" id="templateSubject" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Enter email subject">
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="block text-sm font-medium text-gray-700">Email Content</label>
                                    <div class="text-sm text-gray-500" id="availableVariables">
                                        <!-- Available variables will be shown here -->
                                    </div>
                                </div>
                                <textarea name="content" id="templateContent" rows="15" required
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                          placeholder="Enter your email content in HTML"></textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <button type="button" id="previewTemplate" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Save Template
                                </button>
                                <a href="{{ route('email-templates.index') }}" 
                                   class="text-gray-600 hover:text-gray-900 text-sm">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    
                    <!-- Template Details -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-700">Email Subject</label>
                        <input type="text" name="subject" id="subject" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('subject') }}">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="body" class="block text-sm font-medium text-gray-700">Email Body</label>
                        <textarea name="body" id="body" rows="10" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">You can use HTML formatting and placeholders like: @{{name}}, @{{email}}, @{{phone}}</p>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Available Placeholders:</strong><br>
                                    <span id="availablePlaceholders">
                                        • <code>@{{name}}</code> - Client's name<br>
                                        • <code>@{{email}}</code> - Client's email<br>
                                        • <code>@{{phone}}</code> - Client's phone number
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Template
                        </button>
                        <a href="{{ route('email-templates.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const templateForm = document.getElementById('templateForm');
            const selectedTemplateInput = document.getElementById('selectedTemplate');
            const templateNameInput = document.getElementById('templateName');
            const templateSubjectInput = document.getElementById('templateSubject');
            const templateContent = document.getElementById('templateContent');
            const availableVariablesEl = document.getElementById('availableVariables');
            const previewTemplateBtn = document.getElementById('previewTemplate');
            
            // Template selection
            const templateCards = document.querySelectorAll('.template-card');
            let currentTemplate = null;
            let currentPlaceholders = [];
            
            // Template preview modal
            const previewModal = document.createElement('div');
            previewModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden';
            previewModal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] flex flex-col">
                    <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900">Template Preview</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="this.closest('.fixed').classList.add('hidden')">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 overflow-auto flex-1">
                        <div id="emailPreview" class="bg-white p-6 max-w-2xl mx-auto"></div>
                    </div>
                    <div class="border-t border-gray-200 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Close
                        </button>
                        <button type="button" id="useThisTemplate" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Use This Template
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(previewModal);
            
            // Handle template selection
            templateCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Update active state
                    document.querySelectorAll('.template-card').forEach(c => 
                        c.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500')
                    );
                    this.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
                    
                    // Get template data
                    const templateId = this.dataset.templateId;
                    const placeholders = JSON.parse(this.dataset.placeholders || '[]');
                    const templateName = this.querySelector('.font-medium').textContent;
                    
                    // Store current template data
                    currentTemplate = {
                        id: templateId,
                        name: templateName,
                        placeholders: placeholders
                    };
                    
                    // Update form
                    selectedTemplateInput.value = templateId;
                    templateNameInput.value = templateName || '';
                    templateSubjectInput.value = templateName ? `Your ${templateName}` : '';
                    
                    // Load template content via AJAX or use a default
                    loadTemplateContent(templateId);
                    
                    // Update available variables
                    updateAvailableVariables(placeholders);
                });
            });
            
            // Load template content
            function loadTemplateContent(templateId) {
                // In a real app, you might load this via AJAX
                // For now, we'll use the CBK email templates
                const defaultContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Email Template</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
                        <div style="background-color: #f8f9fa; padding: 30px; border-radius: 8px;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h1 style="color: #1a365d; margin: 0 0 10px 0;">@{{subject}}</h1>
                                <p style="color: #4a5568; margin: 0;">@{{preview_text}}</p>
                            </div>
                            
                            <div style="background-color: #fff; border-radius: 6px; padding: 30px; margin-bottom: 30px;">
                                @yield('content')
                            </div>
                            
                            <div style="text-align: center; color: #718096; font-size: 14px;">
                                <p>  {{ date('Y') }} Your Company. All rights reserved.</p>
                                <p style="margin: 5px 0 0 0;">
                                    <a href="#" style="color: #4299e1; text-decoration: none;">Privacy Policy</a> | 
                                    <a href="#" style="color: #4299e1; text-decoration: none;">Terms of Service</a> | 
                                    <a href="#" style="color: #4299e1; text-decoration: none;">Contact Us</a>
                                </p>
                            </div>
                        </div>
                    </body>
                    </html>
                `;
                
                templateContent.value = defaultContent.trim();
            }
            
            // Update available variables in the UI
            function updateAvailableVariables(placeholders) {
                currentPlaceholders = placeholders || [];
                
                if (placeholders && placeholders.length > 0) {
                    const variablesHtml = placeholders.map(placeholder => 
                        `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2 mb-2 cursor-pointer hover:bg-blue-200" 
                              onclick="insertAtCaret('templateContent', '{{${placeholder}}}')">
                            @{{${placeholder}}}
                        </span>`
                    ).join('');
                    
                    availableVariablesEl.innerHTML = `
                        <span class="text-xs font-medium text-gray-500">Click to insert:</span>
                        ${variablesHtml}
                    `;
                } else {
                    availableVariablesEl.innerHTML = '<span class="text-xs text-gray-500">No variables available for this template.</span>';
                }
            }
            
            // Insert text at cursor position
            window.insertAtCaret = function(textAreaId, text) {
                const textarea = document.getElementById(textAreaId);
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const value = textarea.value;
                
                textarea.value = value.substring(0, start) + text + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + text.length;
                textarea.focus();
                
                // Trigger input event for any listeners
                const event = new Event('input', { bubbles: true });
                textarea.dispatchEvent(event);
            };
            
            // Preview template
            previewTemplateBtn.addEventListener('click', function() {
                if (!currentTemplate) {
                    alert('Please select a template first');
                    return;
                }
                
                const previewContent = templateContent.value;
                const previewHtml = `
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="prose max-w-none">
                            ${previewContent}
                        </div>
                    </div>
                `;
                
                const previewEl = previewModal.querySelector('#emailPreview');
                previewEl.innerHTML = previewHtml;
                
                // Show the modal
                previewModal.classList.remove('hidden');
                
                // Focus the modal for keyboard navigation
                previewModal.focus();
            });
            
            // Use template button in modal
            previewModal.querySelector('#useThisTemplate').addEventListener('click', function() {
                // Just close the modal, the template is already in the form
                previewModal.classList.add('hidden');
            });
            
            // Close modal when clicking outside the content
            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.add('hidden');
                }
            });
            
            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !previewModal.classList.contains('hidden')) {
                    previewModal.classList.add('hidden');
                }
            });
            
            // Form submission
            templateForm.addEventListener('submit', function(e) {
                if (!selectedTemplateInput.value) {
                    e.preventDefault();
                    alert('Please select a template');
                    return false;
                }
                
                // Make sure template content is properly escaped
                const contentTextarea = document.getElementById('templateContent');
                contentTextarea.value = contentTextarea.value.replace(/\{\{/g, '@{{').replace(/\}\}/g, '}}');
                
                return true;
            });
            
            // Add keyboard shortcut for saving (Ctrl+Enter or Cmd+Enter)
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    if (templateForm.checkValidity()) {
                        templateForm.submit();
                    } else {
                        templateForm.reportValidity();
                    }
                }
            });
            
            // Helper function to insert text at cursor position
            function insertAtCaret(textAreaId, text) {
                // This is a fallback in case the window function doesn't work
                const textarea = document.getElementById(textAreaId);
                if (!textarea) return;
                
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const value = textarea.value;
                
                textarea.value = value.substring(0, start) + text + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + text.length;
                textarea.focus();
                
                // Trigger input event
                const event = new Event('input', { bubbles: true });
                textarea.dispatchEvent(event);
            }
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
        /* Custom scrollbar for template cards */
        .template-card::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .template-card::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        .template-card::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        .template-card::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Animation for template selection */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(66, 153, 225, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(66, 153, 225, 0); }
            100% { box-shadow: 0 0 0 0 rgba(66, 153, 225, 0); }
        }
        
        .template-card {
            transition: all 0.2s ease-in-out;
        }
        
        .template-card:hover {
            transform: translateY(-2px);
        }
        
        .template-card.selected {
            animation: pulse 2s infinite;
        }
        
        /* Make the template content textarea more code-editor like */
        #templateContent {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            tab-size: 4;
        }
    </style>
    @endpush
</x-app-layout>
