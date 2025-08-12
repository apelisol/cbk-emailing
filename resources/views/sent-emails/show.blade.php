<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Email Details') }}
            </h2>
            <a href="{{ route('sent-emails.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Sent Emails
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Email Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Email Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                                    <p class="text-gray-900">{{ $sentEmail->subject }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span class="px-2 py-1 text-sm rounded-full 
                                        {{ $sentEmail->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $sentEmail->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $sentEmail->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($sentEmail->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sent At</label>
                                    <p class="text-gray-900">
                                        {{ $sentEmail->sent_at?->format('M j, Y g:i:s A') ?? 'Not sent yet' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                                    <p class="text-gray-900">{{ $sentEmail->created_at->format('M j, Y g:i:s A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Recipient Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="text-gray-900">{{ $sentEmail->recipient_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="text-gray-900">{{ $sentEmail->recipient_email }}</p>
                                </div>
                                @if($sentEmail->client)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Client</label>
                                        <a href="{{ route('clients.show', $sentEmail->client) }}" class="text-blue-600 hover:text-blue-900">
                                            View Client Details
                                        </a>
                                    </div>
                                @endif
                                @if($sentEmail->emailJob)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Campaign</label>
                                        <a href="{{ route('email-campaigns.show', $sentEmail->emailJob) }}" class="text-blue-600 hover:text-blue-900">
                                            View Campaign Details
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($sentEmail->error_message)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <h4 class="font-medium text-red-800 mb-2">Error Message</h4>
                            <p class="text-red-700">{{ $sentEmail->error_message }}</p>
                        </div>
                    @endif

                    <!-- Email Content -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Email Content</h3>
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="prose max-w-none">
                                {!! nl2br(e($sentEmail->body)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>