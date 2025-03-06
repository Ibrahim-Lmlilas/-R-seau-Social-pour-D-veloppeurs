<!DOCTYPE html>
<html lang="en">
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
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row">
            <!-- Connections List -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Connections</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($connectionUsers as $connectionUser)
                                <li class="list-group-item d-flex justify-content-between align-items-center
                                    {{ isset($receiver) && $receiver->id == $connectionUser->id ? 'active' : '' }}">
                                    <a href="{{ route('chat', ['user_id' => $connectionUser->id]) }}" class="d-flex align-items-center text-decoration-none">
                                        @if($connectionUser->profile_picture)
                                            <img src="{{ asset('storage/' . $connectionUser->profile_picture) }}"
                                                class="rounded-circle me-2" width="40" height="40" alt="{{ $connectionUser->name }}">
                                        @else
                                            <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; color: white;">
                                                {{ strtoupper(substr($connectionUser->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div>{{ $connectionUser->name }}</div>
                                            <small class="text-muted">
                                                @if($connectionUser->last_seen)
                                                    {{ \Carbon\Carbon::parse($connectionUser->last_seen)->diffForHumans() }}
                                                @else
                                                    Offline
                                                @endif
                                            </small>
                                        </div>
                                    </a>
                                    @if(isset($unreadCounts[$connectionUser->id]) && $unreadCounts[$connectionUser->id] > 0)
                                        <span class="badge bg-primary rounded-pill">{{ $unreadCounts[$connectionUser->id] }}</span>
                                    @endif
                                </li>
                            @endforeach

                            @if(count($connectionUsers) == 0)
                                <li class="list-group-item text-center">
                                    {{-- No connections found. <a href="{{ route('friends') }}">Add connections</a> --}}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(isset($receiver))
                            <div class="d-flex align-items-center">
                                @if($receiver->profile_picture)
                                    <img src="{{ asset('storage/' . $receiver->profile_picture) }}"
                                        class="rounded-circle me-2" width="40" height="40" alt="{{ $receiver->name }}">
                                @else
                                    <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px; color: white;">
                                        {{ strtoupper(substr($receiver->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $receiver->name }}</h5>
                                    <small class="text-muted">
                                        @if($receiver->last_seen)
                                            {{ \Carbon\Carbon::parse($receiver->last_seen)->diffForHumans() }}
                                        @else
                                            Offline
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @else
                            <h5>Select a connection to start chatting</h5>
                        @endif
                    </div>

                    @if(isset($receiver))
                        <div class="card-body" id="chat-messages" style="height: 400px; overflow-y: auto;">
                            @foreach($messages as $message)
                                <div class="mb-3 {{ $message->user_id == Auth::id() ? 'text-end' : '' }}">
                                    <div class="d-inline-block p-2 rounded {{ $message->user_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }}"
                                        style="max-width: 75%;">
                                        {{ $message->message }}
                                    </div>
                                    <div class="small text-muted mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($message->user_id == Auth::id())
                                            <i class="fas fa-check{{ $message->is_read ? '-double' : '' }} ms-1"></i>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <form id="message-form" class="d-flex">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                                <input type="text" name="message" id="message-input" class="form-control me-2" placeholder="Type a message...">
                                <button type="submit" class="btn btn-primary">Send</button>
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

    @section('scripts')
    @if(isset($receiver))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');

            // Scroll to bottom of chat
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Handle form submission
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (messageInput.value.trim() === '') return;

                const formData = new FormData(messageForm);

                fetch('{{ route('chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: formData.get('receiver_id'),
                        message: formData.get('message')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Create message element
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-3 text-end';

                    const messageContent = document.createElement('div');
                    messageContent.className = 'd-inline-block p-2 rounded bg-primary text-white';
                    messageContent.style.maxWidth = '75%';
                    messageContent.textContent = data.message;

                    const messageTime = document.createElement('div');
                    messageTime.className = 'small text-muted mt-1';
                    messageTime.textContent = data.created_at;

                    const checkIcon = document.createElement('i');
                    checkIcon.className = 'fas fa-check ms-1';
                    messageTime.appendChild(checkIcon);

                    messageDiv.appendChild(messageContent);
                    messageDiv.appendChild(messageTime);

                    chatMessages.appendChild(messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    // Clear input
                    messageInput.value = '';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // You can add Pusher integration here for real-time messaging
        });
    </script>
    @endif
    @endsection
</x-app-layout>
