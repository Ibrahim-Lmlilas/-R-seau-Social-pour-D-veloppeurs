<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Network') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pt-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                    <div class="pt-16 p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                                <p class="text-gray-600 text-sm">{{ $user->industry }}</p>
                            </div>
                            @if($user->github_url)
                                <a href="{{ $user->github_url }}" target="_blank"
                                   class="text-gray-600 hover:text-black transition-colors">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <!-- Skills and Languages -->
                        <div class="space-y-4">
                            @if($user->skills)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Skills</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $user->skills) as $skill)
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($user->programming_languages)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Programming Languages</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $user->programming_languages) as $language)
                                            <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs">
                                                {{ trim($language) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Network Stats -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <div class="text-center">
                                    <span class="block text-2xl font-bold text-gray-900">{{ $user->connections }}</span>
                                    <span class="text-sm text-gray-500">Connections</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-2xl font-bold text-gray-900">
                                        {{ count($pendingRequests) }}
                                    </span>
                                    <span class="text-sm text-gray-500">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pending Requests Section -->
                @if(count($pendingRequests) > 0)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Pending Requests</h3>
                        <div class="divide-y divide-gray-200">
                            @foreach($pendingRequests as $request)
                                @if($request->user)
                                    <div class="py-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $request->user->image) }}"
                                                 alt="{{ $request->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover"/>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $request->user->name }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $request->user->industry }}</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('connections.accept', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('connections.reject', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-full shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Ignore
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Suggested Connections -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">People You May Know</h3>
                    <div class="divide-y divide-gray-200">
                        @forelse($userss as $otherUser)
                            <div class="py-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $otherUser->image) }}"
                                         alt="{{ $otherUser->name }}"
                                         class="w-12 h-12 rounded-full object-cover"/>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $otherUser->name }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $otherUser->industry }}</p>
                                    </div>
                                </div>
                                @if(!Auth::user()->isConnectedOrPendingWith($otherUser))
                                    <form method="POST" action="{{ route('connections.send', $otherUser) }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-full shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Connect
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No suggestions available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
