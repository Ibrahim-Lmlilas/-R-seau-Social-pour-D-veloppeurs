<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Pusher -->
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Yield scripts section for page-specific JavaScript -->
        @yield('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @auth
                    // Initialize Laravel Echo
                    window.Echo = new Echo({
                        broadcaster: 'pusher',
                        key: '{{ env('PUSHER_APP_KEY') }}',
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                        encrypted: true
                    });

                    window.Echo.private('notifications.{{ Auth::id() }}')
                        .listen('.new-notification', (e) => {
                            const notificationCount = document.getElementById('notification-count');
                            if (notificationCount) {
                                const currentCount = parseInt(notificationCount.textContent || '0');
                                notificationCount.textContent = currentCount + 1;
                                notificationCount.classList.remove('hidden');
                            }

                            showNotificationToast(e);

                            console.log('New notification received:', e);
                        });

                    function showNotificationToast(notification) {
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-4 right-4 bg-white shadow-lg rounded-lg p-4 max-w-xs z-50 transform transition-all duration-300 ease-in-out';
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(-20px)';

                        // Create toast content
                        toast.innerHTML = `
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    ${notification.sender && notification.sender.image
                                        ? `<img src="/storage/${notification.sender.image}" class="h-10 w-10 rounded-full">`
                                        : `<div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>`
                                    }
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">${notification.message}</p>
                                    <p class="text-xs text-gray-500">${notification.created_at}</p>
                                </div>
                                <button class="ml-4 text-gray-400 hover:text-gray-500" onclick="this.parentElement.parentElement.remove()">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        `;

                        document.body.appendChild(toast);

                        setTimeout(() => {
                            toast.style.opacity = '1';
                            toast.style.transform = 'translateY(0)';
                        }, 10);

                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translateY(-20px)';
                            setTimeout(() => {
                                toast.remove();
                            }, 300);
                        }, 5000);
                    }
                @endauth
            });
        </script>
    </body>
</html>
