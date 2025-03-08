<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Add Font Awesome for the heart icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .like-button.liked svg {
            fill: #3b82f6;
            stroke: #000000;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Home') }}
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

                        <!-- Skills Section -->
                        @if($user->skills)
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-700">Skills</h3>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach(explode(',', $user->skills) as $skill)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Programming Languages Section -->
                        @if($user->programming_languages)
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-700">Programming Languages</h3>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach(explode(',', $user->programming_languages) as $language)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ trim($language) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Projects Section -->
                        @if($user->projects)
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-700">Projects</h3>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach(explode(',', $user->projects) as $project)
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">{{ trim($project) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Certifications Section -->
                        @if($user->certifications)
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-700">Certifications</h3>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach(explode(',', $user->certifications) as $certification)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ trim($certification) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="text-gray-500 text-sm mt-4">{!! $user->bio !!}</div>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $user->image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                            <input id="searchInput" type="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search posts, users, or hashtags...">

                        </div>
                        <div class="flex justify-between mt-4 pt-4 border-t">
                            <a href="{{ route('posts.createCode') }}" name="post_type" value="code" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                                <span>Code</span>
                            </a>
                            <a href="{{ route('posts.createImage') }}" name="post_type" value="image" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Image</span>
                            </a>
                            <a href="{{ route('posts.createLine') }}" name="post_type" value="link" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <span>Link</span>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Posts -->
@foreach ($posts as $post )
                <div class="bg-white rounded-xl shadow-sm mt-12 post">

                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('storage/' . $post->user->image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{$post->user->name}}</h3>
                                    <p class="text-gray-500 text-sm">{{$post->user->industry}}</p>
                                    <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if(Auth::user()->id == $post->user_id)
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg origin-top-right">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <a href="{{ route('posts.edit', $post->id) }}" class=" px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=" px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <h3 class="font-semibold post-title">{{ $post->title }}</h3>
                            <p class="text-gray-700 post-content">{{$post->description}}</p>

                            <div class="bg-white rounded-xl shadow-sm">
                                <div class="p-4">

                                        <div class="mb-4">


                                            @if($post->type === 'line')
                                                <a href="{{ $post->line }}" class="text-gray-700">{{ $post->line }}</a>

                                            @elseif($post->type === 'code')
                                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">  <pre><code> {{ $post->code }} </code></pre></div>

                                            @elseif($post->type === 'image')
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mt-2 rounded-md"/>
                                            @endif
                                        </div>

                                </div>
                            </div>
                        </div>


                            <div class="mt-4 flex flex-wrap gap-2">
                                @if($post->hashtags)
                                    @foreach(explode(',', $post->hashtags) as $hashtag)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">#{{ trim($hashtag) }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                <div class="flex items-center space-x-4">
                                    <button class="like-button text-gray-500" data-post-id="{{ $post->id }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                    </button>
                                    <span class="likes-count  text-gray-500" data-post-id="{{ $post->id }}">{{ $post->likes()->count() }}</span>
                                    <button class="flex items-center space-x-2  text-gray-500  hover:text-blue-500">
                                        <svg class="w-5 h-5  text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z  "/>
                                        </svg>
                                        <span>{{$post->comments->count()}}</span>
                                    </button>
                                </div>
                                <div class="relative" x-data="{ shareOpen: false }">
                                    <button @click="shareOpen = !shareOpen" class="text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                    <div x-show="shareOpen" @click.away="shareOpen = false" class="absolute right-0 bottom-10 w-48 bg-white rounded-md shadow-lg z-10">
                                        <div class="py-1" role="menu">
                                            <button onclick="shareToSocial('twitter', '{{ route('posts.show', $post->id) }}', '{{ $post->title }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.055 10.055 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                                </svg>
                                                Twitter
                                            </button>
                                            <button onclick="shareToSocial('facebook', '{{ route('posts.show', $post->id) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                                Facebook
                                            </button>
                                            <button onclick="shareToSocial('linkedin', '{{ route('posts.show', $post->id) }}', '{{ $post->title }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                                LinkedIn
                                            </button>
                                            <button onclick="shareToSocial('whatsapp', '{{ route('posts.show', $post->id) }}', '{{ $post->title }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                WhatsApp
                                            </button>
                                            <button onclick="copyToClipboard('{{ route('posts.show', $post->id) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                </svg>
                                                Copy Link
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>

                            <div class="mt-4 border-t pt-4">
                                <form class="comment-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <div class="flex items-start space-x-3">
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User" class="w-8 h-8 rounded-full"/>
                                        <div class="flex-grow">
                                            <textarea name="content" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write a comment..."></textarea>
                                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Comment</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Replace the existing comment display section -->
                                <div class="comments-container mt-4 space-y-4">
                                    @foreach($post->comments()->with('user')->latest()->get() as $comment)
                                        <div class="flex items-start space-x-3 comment-item" id="comment-{{ $comment->id }}">
                                            <img src="{{ asset('storage/' . $comment->user->image) }}" alt="User" class="w-8 h-8 rounded-full"/>
                                            <div class="flex-grow bg-gray-50 rounded-lg p-3">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="font-semibold">{{ $comment->user->name }}</h4>
                                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if(Auth::id() === $comment->user_id)
                                                        <button
                                                            class="delete-comment text-gray-400 hover:text-red-500"
                                                            data-comment-id="{{ $comment->id }}"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            </div>


                    </div>

 @endforeach
                </div>


                {{ $posts->links() }}

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Job Recommendations -->


                    <!-- Suggested Connections -->

                </div>
            </body>

            <script>
                document.querySelectorAll('.like-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const button = this.querySelector('button');
                        const likesCount = button.querySelector('.likes-count');
                        const svg = button.querySelector('svg');

                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: new FormData(this)
                        })
                        .then(response => response.json())
                        .then(data => {
                            likesCount.textContent = data.likes_count;

                            if (data.liked) {
                                svg.setAttribute('fill', 'currentColor');
                                svg.classList.add('text-blue-500');
                            } else {
                                svg.setAttribute('fill', 'none');
                                svg.classList.remove('text-blue-500');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                });

                document.querySelectorAll('.comment-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const postId = this.dataset.postId;
                        const textarea = this.querySelector('textarea');

                        fetch(`/posts/${postId}/comments`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                content: textarea.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Add the new comment to the list
                            const commentsContainer = this.nextElementSibling;
                            const commentHtml = `
                                <div class="flex items-start space-x-3">
                                    <img src="${data.comment.user.image}" alt="User" class="w-8 h-8 rounded-full"/>
                                    <div class="flex-grow bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold">${data.comment.user.name}</h4>
                                            <span class="text-xs text-gray-500">Just now</span>
                                        </div>
                                        <p class="text-gray-700 mt-1">${data.comment.content}</p>
                                    </div>
                                </div>
                            `;
                            commentsContainer.insertAdjacentHTML('afterbegin', commentHtml);

                            textarea.value = '';
                        })
                        .catch(error => console.error('Error:', error));
                    });
                });

                // Add this to your existing script section
                document.querySelectorAll('.delete-comment').forEach(button => {
                    button.addEventListener('click', function() {
                        if (confirm('Are you sure you want to delete this comment?')) {
                            const commentId = this.dataset.commentId;

                            fetch(`/comments/${commentId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById(`comment-${commentId}`).remove();

                                    // Update comment count
                                    const commentCountElement = button.closest('.bg-white').querySelector('.flex.items-center.space-x-4 span:last-child');
                                    const currentCount = parseInt(commentCountElement.textContent);
                                    commentCountElement.textContent = currentCount - 1;
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    });
                });

                // Add to the end of your existing script section
                function shareToSocial(platform, url, title = '') {
                    let shareUrl;

                    switch(platform) {
                        case 'twitter':
                            shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
                            break;
                        case 'facebook':
                            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                            break;
                        case 'linkedin':
                            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
                            break;
                        case 'whatsapp':
                            // Create a combined message with title and URL for WhatsApp
                            const whatsappText = title ? `${title} ${url}` : url;
                            shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(whatsappText)}`;
                            break;
                    }

                    if (shareUrl) {
                        window.open(shareUrl, '_blank', 'width=600,height=550');
                    }
                }

                function copyToClipboard(text) {
                    const input = document.createElement('input');
                    input.style.position = 'fixed';
                    input.style.opacity = '0';
                    input.value = text;
                    document.body.appendChild(input);

                    input.select();
                    document.execCommand('copy');

                    document.body.removeChild(input);

                    alert('Link copied to clipboard!');
                }




        // Add this to your existing script section at the bottom
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) {
                        searchInput.addEventListener('keyup', function() {
                            const searchValue = this.value.toLowerCase();
                            const posts = document.querySelectorAll('.post');

                            posts.forEach(post => {
                                // Get text content from various elements in the post
                                const postContent = post.querySelector('.post-content')?.textContent.toLowerCase() || '';
                                const userName = post.querySelector('.font-semibold')?.textContent.toLowerCase() || '';
                                const hashtagElements = post.querySelectorAll('.text-blue-800');
                                let hashtagText = '';

                                // Combine all hashtag text
                                hashtagElements.forEach(tag => {
                                    hashtagText += ' ' + tag.textContent.toLowerCase();
                                });

                                // Search in content, username, and hashtags
                                if (postContent.includes(searchValue) ||
                                    userName.includes(searchValue) ||
                                    hashtagText.includes(searchValue)) {
                                    post.style.display = '';
                                } else {
                                    post.style.display = 'none';
                                }
                            });
                        });
                    }
                });

                // Add like button functionality
                document.addEventListener('DOMContentLoaded', function() {
                    const likeButtons = document.querySelectorAll('.like-button');

                    likeButtons.forEach(button => {
                        // Check if post is already liked by user and add class
                        fetch(`/posts/${button.dataset.postId}/check-like`, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.liked) {
                                button.classList.add('liked');
                            }
                        });

                        button.addEventListener('click', function() {
                            const postId = this.dataset.postId;
                            const likeCountElement = document.querySelector(`.likes-count[data-post-id="${postId}"]`);

                            fetch(`/posts/${postId}/like`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Update like count
                                likeCountElement.textContent = data.likes_count;

                                // Update like button appearance
                                if (data.liked) {
                                    this.classList.add('liked');
                                } else {
                                    this.classList.remove('liked');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        });
                    });
                });
                </script>


        </x-app-layout>
