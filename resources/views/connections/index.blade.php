<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Posts ') }}
            </h2>
        </x-slot>
        <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Card -->
            <div class="space-y-6 flex flex-col lg:col-span-1 lg:row-span-2">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400 relative overflow-hidden">
                            <img src="{{ asset('storage/'.$user->banner) }}" alt="Description" class="absolute inset-0 w-full h-full object-cover">
                        </div>                        <img src="{{ asset('storage/' . $user->image) }}" alt="Profile"
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                            <a href="{{ $user->github_url }}" target="_blank" class="text-gray-600 hover:text-black">

                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">{{ $user->industry }}</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{$user->skills}}</span>

                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{$user->programming_languages}}</span>

                        </div>
                        <p class="text-gray-500 text-sm mt-2">{{ $user->certifications }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ $user->bio }}</p>




                            <!-- Network Stats with improved layout -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <span class="block text-2xl font-bold text-blue-600">{{ $user->connections }}</span>
                                        <span class="text-sm text-gray-500">Connections</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <span class="block text-2xl font-bold text-blue-600">{{ count($pendingRequests) }}</span>
                                        <span class="text-sm text-gray-500">Pending</span>
                                    </div>
                                </div>
                            </div>


                    </div>
                </div>
            </div>

            <!-- Main Feed -->



                <!-- Right Sidebar -->
                     <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pending Requests Section -->
                @if(count($pendingRequests) > 0)
                    <div class="bg-white rounded-xl shadow-sm p-6 transform transition-all hover:shadow-md">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                            Pending Requests
                            <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ count($pendingRequests) }}</span>
                        </h3>
                        <div class="divide-y divide-gray-200">
                            @foreach($pendingRequests as $request)
                                @if($request->user)
                                    <div class="py-4 flex items-center justify-between hover:bg-gray-50 rounded-lg px-2 transition-colors duration-200">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $request->user->image) }}"
                                                 alt="{{ $request->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover border border-gray-200"/>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $request->user->name }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $request->user->industry }}</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('connections.accept', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('connections.reject', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-xs font-medium rounded-full shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
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
                <div class="bg-white rounded-xl shadow-sm p-6 transform transition-all hover:shadow-md">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        People You May Know
                    </h3>
                    <div class="divide-y divide-gray-200">
                        @forelse($userss as $otherUser)
                            <div class="py-4 flex items-center justify-between hover:bg-gray-50 rounded-lg px-2 transition-colors duration-200">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $otherUser->image) }}"
                                         alt="{{ $otherUser->name }}"
                                         class="w-12 h-12 rounded-full object-cover border border-gray-200"/>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $otherUser->name }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $otherUser->industry }}</p>
                                        @if($otherUser->skills)
                                            <div class="mt-1 flex flex-wrap gap-1">
                                                @foreach(array_slice(explode(',', $otherUser->skills), 0, 2) as $skill)
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                                @if(count(explode(',', $otherUser->skills)) > 2)
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                                        +{{ count(explode(',', $otherUser->skills)) - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(!Auth::user()->isConnectedOrPendingWith($otherUser))
                                    <form method="POST" action="{{ route('connections.send', $otherUser) }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-blue-300 text-xs font-medium rounded-full shadow-sm text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                            </svg>
                                            Connect
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 border border-gray-200 text-xs font-medium rounded-full text-gray-500 bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div class="py-10 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="mt-4 text-gray-500 text-center">No suggestions available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>



                </div>
            </body>

</html>
</x-app-layout>
