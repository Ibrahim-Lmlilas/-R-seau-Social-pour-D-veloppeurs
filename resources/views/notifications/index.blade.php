<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($notifications->where('is_read', false)->count() > 0)
                        <div class="mb-4">
                            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    {{ __('Mark all as read') }}
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="p-4 border rounded-md {{ $notification->is_read ? '' : 'bg-blue-50 dark:bg-gray-700' }}">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-start space-x-3">
                                            @if($notification->sender)

                                                <div>
                                                    <p class="font-medium">{{ $notification->sender->name }}</p>
                                                    <p>{{ $notification->message }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            @else
                                                <div>
                                                    <p>{{ $notification->message }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-read', $notification) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    @else
                        <p class="text-center py-6">{{ __('No notifications') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
