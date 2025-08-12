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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            @foreach($templates as $template)
                                <div class="template-card p-4" data-template-id="{{ $template['id'] }}">
                                    <div class="font-medium text-gray-900">{{ $template['name'] }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $template['preview'] }}</div>
                                    <div class="mt-2">
                                        @foreach($template['placeholders'] as $placeholder)
                                            <span class="placeholder-badge">{{ $placeholder }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="selected_template" id="selectedTemplate" value="">
                    </div>

                    <!-- Template Preview -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Template Preview</h2>
                        <div id="templatePreview" class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-500 text-center py-12">Select a template to preview</p>
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
            const templateCards = document.querySelectorAll('.template-card');
            const templateForm = document.getElementById('templateForm');
            const selectedTemplateInput = document.getElementById('selectedTemplate');
            const templatePreview = document.getElementById('templatePreview');
            const bodyTextarea = document.getElementById('body');
            const subjectInput = document.getElementById('subject');
            const nameInput = document.getElementById('name');
            const availablePlaceholders = document.getElementById('availablePlaceholders');

            // Template selection
            templateCards.forEach(card => {
                card.addEventListener('click', function() {
                    const templateId = this.dataset.templateId;
                    
                    // Update UI
                    templateCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    // Show loading
                    templatePreview.innerHTML = '<p class="text-gray-500 text-center py-12">Loading preview...</p>';
                    
                    // Fetch template preview
                    fetch('{{ route("email-templates.preview") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ template: templateId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            templatePreview.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                            return;
                        }
                        
                        // Update preview
                        templatePreview.innerHTML = data.preview;
                        
                        // Update form fields
                        selectedTemplateInput.value = templateId;
                        
                        // Generate placeholder badges
                        if (data.placeholders && data.placeholders.length > 0) {
                            let placeholdersHtml = '';
                            data.placeholders.forEach(placeholder => {
                                placeholdersHtml += `• <code>@{{${placeholder}}}</code> - ${placeholder.replace(/_/g, ' ')}<br>`;
                            });
                            availablePlaceholders.innerHTML = placeholdersHtml;
                        }
                        
                        // Set default subject and name if not set
                        if (!subjectInput.value) {
                            const templateName = card.querySelector('.font-medium').textContent;
                            subjectInput.value = templateName;
                            nameInput.value = templateName;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading template:', error);
                        templatePreview.innerHTML = '<p class="text-red-500">Error loading template preview</p>';
                    });
                });
            });

            // Form submission
            templateForm.addEventListener('submit', function(e) {
                if (!selectedTemplateInput.value) {
                    e.preventDefault();
                    alert('Please select a template first');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
