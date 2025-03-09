<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Offers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">All Job Offers</h3>
                        <a href="{{ route('jobs.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Post a Job</a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse($jobs as $job)
                            <div class="border-b pb-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xl font-medium text-gray-900">{{ $job->title }}</h4>
                                        <p class="text-gray-600">{{ $job->company }}</p>
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $job->location }}
                                        </div>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @if($job->type)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $job->type }}</span>
                                            @endif
                                            @if($job->experience_level)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $job->experience_level }}</span>
                                            @endif
                                            @if($job->deadline)
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Deadline: {{ $job->deadline->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('jobs.show', $job->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-sm">View</a>
                                        @if(Auth::id() === $job->user_id)
                                            <a href="{{ route('jobs.edit', $job->id) }}" class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">Edit</a>
                                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm" onclick="return confirm('Are you sure you want to delete this job offer?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No job offers available at the moment.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
