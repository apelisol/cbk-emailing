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
    <script src="{{ asset('js/email-template-editor.js') }}"></script>
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
