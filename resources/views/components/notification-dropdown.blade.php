@props(['unreadCount', 'notifications'])

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open" class="relative rounded-full p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 text-xs text-white text-center">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 shadow-lg rounded-md py-1 z-50 origin-top-right"
         style="display: none;">

        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Notifications') }}</h3>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('Mark all as read') }}
                    </button>
                </form>
            @endif
        </div>

        @forelse($notifications as $notification)
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('mark-read-form-{{ $notification->id }}').submit();"
               class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $notification->is_read ? '' : 'bg-blue-50 dark:bg-gray-600' }}">
                <div class="flex">
                    @if($notification->sender)
                        {{-- <img src="{{ $notification->sender->image ?? asset('storage/default-avatar.png') }}" --}}
                        <img src="{{ asset('storage/' . $notification->sender->image) }}"
                             class="h-10 w-10 rounded-full mr-3" alt="{{ $notification->sender->name }}">
                    @endif
                    <div class="flex-1">
                        <p class="text-sm truncate">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </a>
            <form id="mark-read-form-{{ $notification->id }}" action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="hidden">
                @csrf
            </form>
        @empty
            <div class="py-3 px-4 text-sm text-center text-gray-500 dark:text-gray-400">
                {{ __('No notifications') }}
            </div>
        @endforelse

        <div class="border-t border-gray-200 dark:border-gray-600 py-2">
            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                {{ __('View all notifications') }}
            </a>
        </div>
    </div>
</div>
