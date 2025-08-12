<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Email Details') }}
            </h2>
            <a href="{{ route('direct-emails.index') }}" class="text-indigo-600 hover:text-indigo-900">
                &larr; Back to Emails
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">{{ $email->subject }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : 
                                   ($email->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($email->status) }}
                            </span>
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            To: {{ $email->client->name }} &lt;{{ $email->client->email }}&gt;
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            Sent: {{ $email->sent_at ? $email->sent_at->format('M d, Y \a\t H:i') : 'Not sent yet' }}
                        </div>
                    </div>

                    @if($email->status === 'failed' && $email->error)
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        <strong>Error:</strong> {{ $email->error }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Message:</h4>
                        <div class="prose max-w-none">
                            {!! nl2br(e($email->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('direct-emails.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to List
                </a>
                <a href="{{ route('direct-emails.create') }}?client_id={{ $email->client_id }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Send New Email to {{ $email->client->name }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
