<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_clients'] }}</div>
                        <div class="text-gray-600">Total Clients</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['sent_emails'] }}</div>
                        <div class="text-gray-600">Sent Emails</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_emails'] }}</div>
                        <div class="text-gray-600">Pending Emails</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $stats['failed_emails'] }}</div>
                        <div class="text-gray-600">Failed Emails</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $stats['upcoming_scheduled'] }}</div>
                        <div class="text-gray-600">Scheduled Campaigns</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Sent Emails -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Sent Emails</h3>
                        <div class="space-y-3">
                            @forelse($recentSentEmails as $email)
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-medium">{{ $email->subject }}</div>
                                        <div class="text-sm text-gray-600">To: {{ $email->recipient_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $email->sent_at?->diffForHumans() ?? $email->created_at->diffForHumans() }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $email->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($email->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500">No emails sent yet.</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('sent-emails.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all sent emails →</a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Scheduled Emails -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Upcoming Campaigns</h3>
                        <div class="space-y-3">
                            @forelse($upcomingEmails as $campaign)
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-medium">{{ $campaign->subject }}</div>
                                        <div class="text-sm text-gray-600">{{ count($campaign->recipient_ids) }} recipients</div>
                                        <div class="text-xs text-gray-500">{{ $campaign->scheduled_at->format('M j, Y g:i A') }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500">No upcoming campaigns.</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('email-campaigns.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all campaigns →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="flex space-x-4">
                            <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Client
                            </a>
                            <a href="{{ route('email-templates.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Create Template
                            </a>
                            <a href="{{ route('email-campaigns.create') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Send Campaign
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>