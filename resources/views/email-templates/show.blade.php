<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Template Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('email-templates.edit', $emailTemplate) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Template
                </a>
                <a href="{{ route('email-templates.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Templates
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Template Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Template Details -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Template Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $emailTemplate->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Subject</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $emailTemplate->subject }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Template Type</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            @if($emailTemplate->template_type === 'cbk-email-templates')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    CBK Template
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Custom Template
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="pt-4 border-t border-gray-200">
                                        <label class="block text-sm font-medium text-gray-500 mb-2">Created</label>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $emailTemplate->created_at->format('M j, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Placeholders -->
                            <div class="mt-6 bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Variables</h3>
                                @if($emailTemplate->placeholders && count($emailTemplate->placeholders) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($emailTemplate->placeholders as $placeholder)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 mb-2">
                                                {{{{ $placeholder }}}}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No placeholders found in this template.</p>
                                @endif
                                    These placeholders will be replaced with actual client data when emails are sent.
                                </p>
                            @else
                                <p class="text-gray-500">No placeholders found in this template.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Template Preview -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Template Preview</h3>
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="mb-4">
                                <strong>Subject:</strong> {{ $emailTemplate->subject }}
                            </div>
                            <div class="border-t pt-4">
                                <strong>Body:</strong>
                                <div class="mt-3 prose max-w-none">
                                    {!! nl2br(e($emailTemplate->body)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Statistics -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Usage Statistics</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $emailTemplate->emailJobs()->count() }}</div>
                                    <div class="text-sm text-gray-600">Times Used</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $emailTemplate->emailJobs()->where('status', 'completed')->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Completed Campaigns</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600">
                                        {{ $emailTemplate->emailJobs()->where('status', 'pending')->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Pending Campaigns</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('email-campaigns.create') }}?template={{ $emailTemplate->id }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Create Campaign with this Template
                            </a>
                            <button type="button" onclick="copyTemplate()" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Copy Template Content
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyTemplate() {
            const content = `Subject: {{ $emailTemplate->subject }}\n\nBody:\n{{ $emailTemplate->body }}`;
            navigator.clipboard.writeText(content).then(() => {
                alert('Template content copied to clipboard!');
            });
        }
    </script>
</x-app-layout>