<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clients.edit', $client) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('clients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Clients
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Client Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Client Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="text-gray-900">{{ $client->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="text-gray-900">{{ $client->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <p class="text-gray-900">{{ $client->phone ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <p class="text-gray-900">{{ $client->created_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email History -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Email History</h3>
                            @if($sentEmails->count() > 0)
                                <div class="space-y-4">
                                    @foreach($sentEmails as $email)
                                        <div class="border rounded-lg p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-medium text-gray-900">{{ $email->subject }}</h4>
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $email->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($email->status) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit(strip_tags($email->body), 150) }}</p>
                                            <div class="flex justify-between items-center text-xs text-gray-500">
                                                <span>{{ $email->sent_at?->format('M j, Y g:i A') ?? $email->created_at->format('M j, Y g:i A') }}</span>
                                                @if($email->emailJob)
                                                    <span>Campaign: {{ $email->emailJob->type === 'template' ? 'Template' : 'Custom' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    {{ $sentEmails->links() }}
                                </div>
                            @else
                                <p class="text-gray-500">No emails sent to this client yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>