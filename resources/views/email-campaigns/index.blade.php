<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Email Campaigns') }}
            </h2>
            <a href="{{ route('email-campaigns.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Campaign
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($emailJobs->count() > 0)
                        <div class="space-y-4">
                            @foreach($emailJobs as $job)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg">{{ $job->subject }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Type: {{ $job->type === 'template' ? 'Template' : 'Custom' }}
                                                @if($job->template)
                                                    ({{ $job->template->name }})
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="px-3 py-1 text-sm rounded-full 
                                                {{ $job->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $job->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $job->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $job->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-3">{{ Str::limit(strip_tags($job->body), 150) }}</p>
                                    
                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <div class="flex space-x-4">
                                            <span>Recipients: {{ count($job->recipient_ids ?? []) }}</span>
                                            <span>Scheduled: {{ $job->scheduled_at->format('M j, Y g:i A') }}</span>
                                            <span>Created: {{ $job->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex space-x-3">
                                            <a href="{{ route('email-campaigns.show', $job) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                            @if($job->status === 'pending')
                                                <form action="{{ route('email-campaigns.destroy', $job) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                            onclick="return confirm('Are you sure you want to cancel this campaign?')">Cancel</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    @if($job->sentEmails()->exists())
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <div class="flex space-x-4 text-xs text-gray-600">
                                                <span>Sent: {{ $job->sentEmails()->where('status', 'sent')->count() }}</span>
                                                <span>Pending: {{ $job->sentEmails()->where('status', 'pending')->count() }}</span>
                                                <span>Failed: {{ $job->sentEmails()->where('status', 'failed')->count() }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $emailJobs->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No email campaigns found.</p>
                            <a href="{{ route('email-campaigns.create') }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                Create Your First Campaign
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>