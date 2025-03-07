<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Add Pusher JS SDK -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex h-[600px]">
                        <!-- Connections List -->
                        <div class="w-1/3 border-r dark:border-gray-700 pr-4">
                            <h3 class="text-lg font-semibold mb-4">Connections</h3>
                            <div class="space-y-2 overflow-y-auto" style="max-height: 550px;">
                                @foreach($connectionUsers as $connectionUser)
                                    <a href="{{ route('chat', ['user_id' => $connectionUser->id]) }}"
                                       class="flex items-center p-3 rounded-lg {{ isset($receiver) && $receiver->id == $connectionUser->id ? 'bg-gray-100 dark:bg-gray-700' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                        <div class="flex-shrink-0 relative">
                                            @if($connectionUser->image)
                                                <img src="{{ asset('storage/' . $connectionUser->image) }}"
                                                    class="w-10 h-10 rounded-full object-cover" alt="{{ $connectionUser->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white">
                                                    {{ strtoupper(substr($connectionUser->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3 flex-grow">
                                            <div class="font-medium">{{ $connectionUser->name }}</div>

                                        </div>
                                        @if(isset($unreadCounts[$connectionUser->id]) && $unreadCounts[$connectionUser->id] > 0)
                                            <div class="ml-2">
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold rounded-full bg-blue-500 text-white">
                                                    {{ $unreadCounts[$connectionUser->id] }}
                                                </span>
                                            </div>
                                        @endif
                                    </a>
                                @endforeach

                                @if(count($connectionUsers) == 0)
                                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        No connections found.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Chat Area -->
                        <div class="w-2/3 pl-4 flex flex-col">
                            @if(isset($receiver))
                                <div class="flex items-center pb-4 border-b dark:border-gray-700">
                                    <div class="flex-shrink-0 relative">
                                        @if($receiver->image)
                                            <img src="{{ asset('storage/' . $receiver->image) }}"
                                                class="w-10 h-10 rounded-full object-cover" alt="{{ $receiver->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white">
                                                {{ strtoupper(substr($receiver->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="absolute bottom-0 right-0 w-3 h-3 border-white dark:border-gray-800"></div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="font-medium">{{ $receiver->name }}</div>

                                    </div>
                                </div>

                                <div id="chat-messages" class="flex-grow py-4 overflow-y-auto" style="height: 400px;">
                                    @foreach($messages as $message)
                                        <div class="mb-4 {{ $message->user_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                            <div class="inline-block max-w-[70%] px-4 py-2 rounded-lg {{ $message->user_id == Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                                                {{ $message->message }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $message->created_at->format('H:i') }}
                                                @if($message->user_id == Auth::id())
                                                    <span class="ml-1">
                                                        @if($message->is_read==false)
                                                            <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M18 7l-8 8-4-4 1.5-1.5L10 12l6.5-6.5L18 7z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-3 h-3 inline text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M18 7l-8 8-4-4 1.5-1.5L10 12l6.5-6.5L18 7z"/>
                                                            </svg>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="pt-4 border-t dark:border-gray-700">
                                    <form id="message-form" class="flex">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $receiver->id ?? '' }}">
                                        <input type="text" name="message" id="message-input"
                                               class="flex-grow rounded-l-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="Type a message...">
                                        <button type="submit"
                                                class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card-body text-center py-5">
                                    <i class="fas fa-comments fa-3x mb-3 text-muted"></i>
                                    <p>Select a connection from the list to start chatting</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    @if(isset($receiver))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const receiverId = {{ $receiver->id }};
            const currentUserId = {{ Auth::id() }};

            chatMessages.scrollTop = chatMessages.scrollHeight;

            console.log('Alo ');

            // Set up Pusher with debug logging
            Pusher.logToConsole = true;

            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true,
                authEndpoint: '/broadcasting/auth'
            });

            pusher.connection.bind('private-chat', function() {
                console.log('Successfully connected to Pusher!');
            });

            pusher.connection.bind('error', function(err) {
                console.error('Pusher connection error:', err);
            });

            // Subscribe to the private chat channel
            const channelName = 'private-chat.' + currentUserId;
            console.log('Subscribing to channel:', channelName);

            const channel = pusher.subscribe(channelName);

            channel.bind('pusher:subscription_succeeded', function() {
                console.log('Successfully subscribed to channel:', channelName);
            });

            channel.bind('pusher:subscription_error', function(error) {
                console.error('Error subscribing to channel:', error);
            });

            // Listen for new message events
            channel.bind('new-message', function(data) {
                console.log('New message received via Pusher:', data);

                // Only add the message if it's from the current chat conversation
                if (data.message.user_id == receiverId) {
                    // Add the received message to the chat
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-4 text-left';

                    const messageContent = document.createElement('div');
                    messageContent.className = 'inline-block max-w-[70%] px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700';
                    messageContent.textContent = data.message.message;

                    const messageTime = document.createElement('div');
                    messageTime.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
                    messageTime.textContent = data.message.created_at;

                    messageDiv.appendChild(messageContent);
                    messageDiv.appendChild(messageTime);
                    chatMessages.appendChild(messageDiv);

                    // Scroll to the bottom of the chat
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    // Mark the message as read
                    markMessageAsRead(data.message.id);
                }
            });

            // Function to mark a message as read
            function markMessageAsRead(messageId) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/chat/mark-as-read/${messageId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => console.log('Message marked as read:', data))
                .catch(error => console.error('Error marking message as read:', error));
            }

            // Handle form submission
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (messageInput.value.trim() === '') return;

                // Get the CSRF token from the meta tag
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send the message using fetch with proper headers
                fetch('{{ route('chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: messageInput.value.trim()
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Message sent successfully:', data);

                    // Add the sent message to the chat
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-4 text-right';

                    const messageContent = document.createElement('div');
                    messageContent.className = 'inline-block max-w-[70%] px-4 py-2 rounded-lg bg-blue-500 text-white';
                    messageContent.textContent = data.message;

                    const messageTime = document.createElement('div');
                    messageTime.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
                    messageTime.innerHTML = data.created_at + ' <span class="ml-1"><svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg></span>';

                    messageDiv.appendChild(messageContent);
                    messageDiv.appendChild(messageTime);
                    chatMessages.appendChild(messageDiv);

                    // Clear the input field
                    messageInput.value = '';

                    // Scroll to the bottom of the chat
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                });
            });
        });
    </script>
    @endif
    @endsection
</x-app-layout>
