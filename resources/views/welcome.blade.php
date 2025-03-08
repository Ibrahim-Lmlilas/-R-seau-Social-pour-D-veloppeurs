<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DevConnect - Social Network for Developers</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Add Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 dark:text-white/80">
        <div class="min-h-screen">
            <!-- Header/Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">

                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        </div>

                        @if (Route::has('login'))
                            <div class="flex space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-800 dark:to-indigo-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Connect with developers around the world</h1>
                            <p class="text-xl text-blue-100 mb-8">Build your professional network, share your projects, and discover new opportunities in the tech industry.</p>
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-md hover:bg-blue-50 transition text-center">Join DevConnect</a>
                                @endif
                                <a href="#features" class="px-6 py-3 border border-white text-white font-semibold rounded-md hover:bg-white/10 transition text-center">Learn More</a>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Developers collaborating" class="rounded-lg shadow-xl">
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-50 dark:from-gray-900 to-transparent"></div>
            </div>

            <!-- Features Section -->
            <section id="features" class="py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Why Join DevConnect?</h2>
                        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">The professional network built specifically for developers and tech professionals.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-network-wired text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Build Your Network</h3>
                            <p class="text-gray-600 dark:text-gray-400">Connect with other developers, tech professionals, and companies to expand your professional network.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-code text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Showcase Projects</h3>
                            <p class="text-gray-600 dark:text-gray-400">Share your work, get feedback from peers, and build a portfolio that highlights your technical skills.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-comments text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Engage in Discussions</h3>
                            <p class="text-gray-600 dark:text-gray-400">Participate in technical discussions, share knowledge, and learn from other developers in the community.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex justify-center md:justify-start">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        </div>
                        <div class="mt-8 md:mt-0">
                            <p class="text-center md:text-right text-gray-500 dark:text-gray-400">
                                &copy; {{ date('Y') }} DevConnect. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
