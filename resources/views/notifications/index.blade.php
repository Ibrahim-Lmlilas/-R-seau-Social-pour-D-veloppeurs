
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
                                                <img src="{{ $notification->sender->avatar ?? asset('images/default-avatar.png') }}"
                                                     alt="Avatar" class="w-10 h-10 rounded-full">
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
                                                        {{ __('Mark as read') }}
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <p class="text-center py-6">{{ __('No notifications') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
