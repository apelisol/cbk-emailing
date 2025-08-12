<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Campaign Details') }}
            </h2>
            <div class="flex space-x-2">
                @if($emailJob->status === 'pending')
                    <form action="{{ route('email-campaigns.destroy', $emailJob) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                onclick="return confirm('Are you sure you want to cancel this campaign?')">
                            Cancel Campaign
                        </button>
                    </form>
                @endif
                <a href="{{ route('email-campaigns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Campaigns
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Campaign Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Campaign Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                                    <p class="text-gray-900">{{ $emailJob->subject }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                    <p class="text-gray-900">
                                        {{ $emailJob->type === 'template' ? 'Template' : 'Custom Message' }}
                                        @if($emailJob->template)
                                            <span class="text-sm text-gray-600">({{ $emailJob->template->name }})</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span class="px-2 py-1 text-sm rounded-full 
                                        {{ $emailJob->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $emailJob->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $emailJob->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $emailJob->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($emailJob->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Scheduled At</label>
                                    <p class="text-gray-900">{{ $emailJob->scheduled_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Recipients</label>
                                    <p class="text-gray-900">{{ $recipients->count() }} clients</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created</label>
                                    <p class="text-gray-900">{{ $emailJob->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>

                            <!-- Email Progress -->
                            @if($emailJob->sentEmails()->exists())
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="font-medium mb-3">Email Progress</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-green-600">Sent:</span>
                                            <span>{{ $emailJob->sentEmails()->where('status', 'sent')->count() }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-yellow-600">Pending:</span>
                                            <span>{{ $emailJob->sentEmails()->where('status', 'pending')->count() }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-red-600">Failed:</span>
                                            <span>{{ $emailJob->sentEmails()->where('status', 'failed')->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recipients -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Recipients</h3>
                            <div class="space-y-2">
                                @foreach($recipients as $client)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-medium text-sm">{{ $client->name }}</div>
                                            <div class="text-xs text-gray-600">{{ $client->email }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Content & Delivery Status -->
                <div class="lg:col-span-2">
                    <!-- Email Preview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Email Content</h3>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="mb-3">
                                    <strong>Subject:</strong> {{ $emailJob->subject }}
                                </div>
                                <div>
                                    <strong>Body:</strong>
                                    <div class="mt-2 prose prose-sm max-w-none">
                                        {!! nl2br(e($emailJob->body)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Status -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Delivery Status</h3>
                            
                            @if($sentEmails->count() > 0)
                                <div class="space-y-3">
                                    @foreach($sentEmails as $email)
                                        <div class="border rounded-lg p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="font-medium">{{ $email->recipient_name }}</div>
                                                    <div class="text-sm text-gray-600">{{ $email->recipient_email }}</div>
                                                    @if($email->error_message)
                                                        <div class="text-sm text-red-600 mt-1">{{ $email->error_message }}</div>
                                                    @endif
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $email->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                        {{ ucfirst($email->status) }}
                                                    </span>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $email->sent_at?->format('M j, g:i A') ?? $email->created_at->format('M j, g:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    {{ $sentEmails->links() }}
                                </div>
                            @else
                                <p class="text-gray-500">No emails have been processed yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>