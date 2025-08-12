<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Template Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('email-templates.edit', $emailTemplate) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Template
                </a>
                <a href="{{ route('email-templates.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Templates
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Template Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Template Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="text-gray-900">{{ $emailTemplate->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                                    <p class="text-gray-900">{{ $emailTemplate->subject }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created</label>
                                    <p class="text-gray-900">{{ $emailTemplate->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="text-gray-900">{{ $emailTemplate->updated_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Placeholders</h3>
                            @if($emailTemplate->placeholders && count($emailTemplate->placeholders) > 0)
                                <div class="space-y-2">
                                    @foreach($emailTemplate->placeholders as $placeholder)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 mb-2">
                                            {{{{ $placeholder }}}}
                                        </span>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-600 mt-3">
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