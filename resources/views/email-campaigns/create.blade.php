<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Email Campaign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('email-campaigns.store') }}" method="POST" x-data="campaignForm()">
                        @csrf
                        
                        <!-- Campaign Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Campaign Type</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="template" x-model="type" class="mr-2">
                                    <span>Use Existing Template</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="custom" x-model="type" class="mr-2">
                                    <span>Create Custom Message</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Template Selection -->
                        <div x-show="type === 'template'" class="mb-6">
                            <label for="template_id" class="block text-sm font-medium text-gray-700">Select Template</label>
                            <select name="template_id" id="template_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Choose a template...</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->name }} - {{ $template->subject }}
                                    </option>
                                @endforeach
                            </select>
                            @error('template_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Custom Message -->
                        <div x-show="type === 'custom'" class="mb-6">
                            <div class="mb-4">
                                <label for="custom_subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <input type="text" name="custom_subject" id="custom_subject" value="{{ old('custom_subject') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('custom_subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="custom_body" class="block text-sm font-medium text-gray-700">Message Body</label>
                                <textarea name="custom_body" id="custom_body" rows="8"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('custom_body') }}</textarea>
                                @error('custom_body')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">You can use placeholders: {{name}}, {{email}}, {{phone}}</p>
                            </div>
                        </div>

                        <!-- Recipients -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Recipients</label>
                            
                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="mr-2">
                                    <span class="font-medium">Select All Clients ({{ $clients->count() }})</span>
                                </label>
                            </div>

                            <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-md p-3">
                                @foreach($clients as $client)
                                    <label class="flex items-center py-2">
                                        <input type="checkbox" name="recipient_ids[]" value="{{ $client->id }}" 
                                               x-model="selectedRecipients" class="mr-3"
                                               {{ in_array($client->id, old('recipient_ids', [])) ? 'checked' : '' }}>
                                        <div>
                                            <div class="font-medium">{{ $client->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $client->email }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('recipient_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @if($clients->isEmpty())
                                <div class="text-center py-4">
                                    <p class="text-gray-500">No clients available.</p>
                                    <a href="{{ route('clients.create') }}" class="text-blue-600 hover:text-blue-900">Add your first client</a>
                                </div>
                            @endif
                        </div>

                        <!-- Schedule -->
                        <div class="mb-6">
                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Schedule Send Time</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                   value="{{ old('scheduled_at', now()->addMinutes(5)->format('Y-m-d\TH:i')) }}" required
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('scheduled_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Emails will be queued and sent at the scheduled time</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Schedule Campaign
                            </button>
                            <a href="{{ route('email-campaigns.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function campaignForm() {
            return {
                type: '{{ old("type", "template") }}',
                selectAll: false,
                selectedRecipients: @json(old('recipient_ids', [])),
                
                toggleAll() {
                    const checkboxes = document.querySelectorAll('input[name="recipient_ids[]"]');
                    if (this.selectAll) {
                        this.selectedRecipients = Array.from(checkboxes).map(cb => cb.value);
                    } else {
                        this.selectedRecipients = [];
                    }
                }
            }
        }
    </script>
</x-app-layout>