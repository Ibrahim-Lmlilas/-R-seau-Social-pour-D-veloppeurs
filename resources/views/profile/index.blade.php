<x-app-layout>
    <style>
        /* Smooth transitions */
        .profile-section {
            transition: all 0.3s ease;
        }
        .profile-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* LinkedIn specific colors */
        .linkedin-blue {
            background-color: #0a66c2;
        }
        .linkedin-blue:hover {
            background-color: #004182;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #0a66c2;
            border-radius: 4px;
        }
    </style>

    <!-- Main Container -->
    <div class="profile-page bg-[#f3f2f0] min-h-screen pb-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden profile-section">
                <!-- Cover Photo -->
                <div class="relative h-48 bg-gradient-to-r from-blue-500 to-blue-600">


                    <!-- Edit Cover Button -->
                    <button class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>

                <!-- Profile Info Section -->
                <div class="relative px-6 pt-16 pb-6">
                    <!-- Profile Picture -->
                    <div class="absolute -top-16 left-6">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                 alt="{{ $user->name }}"
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">

                            <!-- Edit Profile Picture Button -->
                            <button class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="ml-0 sm:ml-36">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-lg text-gray-600 mt-1">{{ $user->technical_skills }}</p>
                                <p class="text-gray-500 mt-1">{{ $user->location ?? 'Add location' }}</p>
                                <p class="text-blue-600 text-sm mt-2">500+ connections</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <button class="linkedin-blue text-white px-5 py-2 rounded-full text-sm font-semibold">
                                    Connect
                                </button>
                                <button class="border border-blue-600 text-blue-600 px-5 py-2 rounded-full text-sm font-semibold hover:bg-blue-50">
                                    Message
                                </button>
                                <button class="border border-gray-300 text-gray-600 px-3 py-2 rounded-full hover:bg-gray-50">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- About Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6 profile-section">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900">About</h2>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z" />
                                    <path d="M11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                        </div>
                        <div class="text-gray-600 prose max-w-none">
                            {!! $user->bio !!}
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6 profile-section">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900">Experience</h2>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Projects Completed</h3>
                                <p class="text-gray-600">{{ $user->completed_projects }} successful projects</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Contact Info -->
                    <div class="bg-white rounded-lg shadow-sm p-6 profile-section">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Contact Info</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span class="text-gray-600">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span class="text-gray-600">{{ $user->phone_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Skills & Endorsements -->
                    <div class="bg-white rounded-lg shadow-sm p-6 profile-section">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Skills & Endorsements</h2>
                        <div class="space-y-4">
                            @foreach(explode(',', $user->certifications) as $certification)
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">{{ trim($certification) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- GitHub Profile -->
                    <a href="{{ $user->github_link }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg"
                                 alt="GitHub"
                                 class="w-6 h-6">
                            <span class="text-gray-900 font-medium">GitHub Profile</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
