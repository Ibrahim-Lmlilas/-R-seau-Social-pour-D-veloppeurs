<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid Container -->
            <div class="grid grid-cols-2 grid-rows-[auto_auto] gap-6">
                <!-- Card 1 - Profile Info -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Profile Information') }}
                                </h2>
                            </header>

                            <div class="mt-6 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $user->photo) }}"
                                     alt="{{ $user->name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->phone_number }}</p>
                                    <a href="{{ $user->github_link }}"
                                       target="_blank"
                                       class="inline-flex items-center mt-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $user->github_username }}
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Card 2 - Contact Info -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('skills') }}
                                </h2>
                            </header>

                            <div class="mt-6 space-y-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span>{{ $user->technical_skills }}</span>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Card 3 - About (Full Width) -->
                <div class="col-span-2 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-full">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('About') }}
                                </h2>
                            </header>

                            <div class="mt-6 text-sm text-gray-600 dark:text-gray-400">
                                {!! $user->bio !!}
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Card 4 - Skills -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2   class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('certifications') }}
                                </h2>
                            </header>

                            <div class="mt-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $user->certifications) as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
