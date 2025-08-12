<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Email Templates') }}
            </h2>
            <a href="{{ route('email-templates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($templates->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($templates as $template)
                                <div class="border rounded-lg p-4">
                                    <div class="mb-3">
                                        <h3 class="font-semibold text-lg">{{ $template->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $template->subject }}</p>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-4">{{ Str::limit(strip_tags($template->body), 100) }}</p>
                                    
                                    @if($template->placeholders && count($template->placeholders) > 0)
                                        <div class="mb-4">
                                            <p class="text-xs text-gray-500 mb-1">Placeholders:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($template->placeholders as $placeholder)
                                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                        {{{{ $placeholder }}}}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">{{ $template->created_at->format('M j, Y') }}</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('email-templates.show', $template) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                            <a href="{{ route('email-templates.edit', $template) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                            <form action="{{ route('email-templates.destroy', $template) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $templates->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No email templates found.</p>
                            <a href="{{ route('email-templates.create') }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                Create Your First Template
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>