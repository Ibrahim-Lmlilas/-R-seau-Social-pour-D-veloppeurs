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
                {{ __('Connections') }}
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
                        <p class="text-gray-500 text-sm mt-2">{{ $user->certifications }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ $user->bio }}</p>



                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{$user->skills}}</span>

                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Connections</span>
                                <span class="text-blue-600 font-medium">{{ $user->connections }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Posts</span>
                                <span class="text-blue-600 font-medium">{{ $postCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold mb-4">Suggested Connections</h3>
                    <div class="space-y-4">
                        @foreach( $userss as $otherUser)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $otherUser->image) }}" alt="User" class="w-10 h-10 rounded-full"/>
                                    <div>
                                        <h4 class="font-medium">{{ $otherUser->name }}</h4>
                                        <p class="text-gray-500 text-sm">{{$otherUser->industry}}</p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pending Connection Requests -->
            <div class="lg:col-span-2 space-y-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Pending Connection Requests</h3>
                        <div class="space-y-4">
                            @if(count($pendingRequests) > 0)
                                @foreach($pendingRequests as $request)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ asset('storage/' . $request->user->image) }}" alt="User" class="w-10 h-10 rounded-full"/>
                                            <div>
                                                <h4 class="font-medium">{{ $request->user->name }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $request->user->industry }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <form method="POST" action="{{ route('connections.accept', $request->user) }}">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('connections.reject', $request->user) }}">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No pending connection requests.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>





            </body>
            </html>

    </x-app-layout>
