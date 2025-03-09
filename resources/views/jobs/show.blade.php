<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-600">{{ $job->company }}</p>
                        </div>
                        <div class="flex space-x-2">
                            @if(Auth::id() === $job->user_id)
                                <a href="{{ route('jobs.edit', $job->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Edit</a>
                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this job offer?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h2 class="text-xl font-semibold mb-2">Job Description</h2>
                                <div class="prose max-w-none">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>

                            @if($job->skills_required)
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">Required Skills</h2>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $job->skills_required) as $skill)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-lg font-semibold mb-4">Job Details</h2>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Location</h3>
                                    <p class="mt-1">{{ $job->location }}</p>
                                </div>

                                @if($job->type)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Job Type</h3>
                                        <p class="mt-1">{{ $job->type }}</p>
                                    </div>
                                @endif

                                @if($job->experience_level)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Experience Level</h3>
                                        <p class="mt-1">{{ $job->experience_level }}</p>
                                    </div>
                                @endif

                                @if($job->salary_range)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Salary Range</h3>
                                        <p class="mt-1">{{ $job->salary_range }}</p>
                                    </div>
                                @endif

                                @if($job->deadline)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Application Deadline</h3>
                                        <p class="mt-1">{{ $job->deadline->format('F j, Y') }}</p>
                                    </div>
                                @endif

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Posted</h3>
                                    <p class="mt-1">{{ $job->created_at->format('F j, Y') }}</p>
                                </div>

                                @if($job->application_url)
                                    <div class="mt-6">
                                        <a href="{{ $job->application_url }}" target="_blank" class="w-full block text-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                            Apply for this position
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-6">
                                        <a href="mailto:{{ $job->user->email }}?subject=Application for {{ $job->title }}" class="w-full block text-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                            Contact employer
                                        </a>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('jobs.index') }}" class="text-blue-500 hover:text-blue-700">
                                        &larr; Back to all job listings
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
