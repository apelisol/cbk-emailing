<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sent Emails') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filters -->
                    <div class="mb-6">
                        <form method="GET" class="flex flex-wrap gap-4">
                            <div>
                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            <div>
                                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                                <a href="{{ route('sent-emails.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    @if($sentEmails->count() > 0)
                        <div class="space-y-4">
                            @foreach($sentEmails as $email)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ $email->subject }}</h3>
                                            <p class="text-sm text-gray-600">To: {{ $email->recipient_name }} ({{ $email->recipient_email }})</p>
                                            @if($email->emailJob)
                                                <p class="text-xs text-gray-500">Campaign: {{ $email->emailJob->type === 'template' ? 'Template' : 'Custom' }}</p>
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
                                                {{ $email->sent_at?->format('M j, Y g:i A') ?? $email->created_at->format('M j, Y g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-700 mb-3">{{ Str::limit(strip_tags($email->body), 200) }}</p>
                                    
                                    @if($email->error_message)
                                        <div class="bg-red-50 border border-red-200 rounded p-2 mb-3">
                                            <p class="text-sm text-red-700">Error: {{ $email->error_message }}</p>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <div class="text-xs text-gray-500">
                                            @if($email->client)
                                                <a href="{{ route('clients.show', $email->client) }}" class="text-blue-600 hover:text-blue-900">
                                                    View Client
                                                </a>
                                            @endif
                                        </div>
                                        <a href="{{ route('sent-emails.show', $email) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $sentEmails->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No sent emails found.</p>
                            @if(!request()->has('status') && !request()->has('search'))
                                <a href="{{ route('email-campaigns.create') }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    Send Your First Campaign
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>