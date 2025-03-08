<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="skills" :value="__('Skills')" />
            <div id="skills-container" class="space-y-2">
                @if($user->skills)
                    @php
                        $skillsArray = explode(',', $user->skills);
                    @endphp
                    @foreach($skillsArray as $index => $skill)
                        <div class="skill-input-group flex items-center">
                            <x-text-input name="skills[]" type="text" class="mt-1 block w-full" value="{{ trim($skill) }}" />
                            <button type="button" class="remove-skill ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="skill-input-group flex items-center">
                        <x-text-input name="skills[]" type="text" class="mt-1 block w-full" placeholder="e.g. JavaScript" />
                        <button type="button" class="remove-skill ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-skill" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-sm">
                {{ __('+ Add Skill') }}
            </button>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div>
            <x-input-label for="programming_languages" :value="__('Programming Languages')" />
            <div id="languages-container" class="space-y-2">
                @if($user->programming_languages)
                    @php
                        $languagesArray = explode(',', $user->programming_languages);
                    @endphp
                    @foreach($languagesArray as $index => $language)
                        <div class="language-input-group flex items-center">
                            <x-text-input name="programming_languages[]" type="text" class="mt-1 block w-full" value="{{ trim($language) }}" />
                            <button type="button" class="remove-language ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="language-input-group flex items-center">
                        <x-text-input name="programming_languages[]" type="text" class="mt-1 block w-full" placeholder="e.g. Python" />
                        <button type="button" class="remove-language ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-language" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-sm">
                {{ __('+ Add Programming Language') }}
            </button>
            <x-input-error class="mt-2" :messages="$errors->get('programming_languages')" />
        </div>

        <div>
            <x-input-label for="projects" :value="__('Projects')" />
            <div id="projects-container" class="space-y-2">
                @if($user->projects)
                    @php
                        $projectsArray = explode(',', $user->projects);
                    @endphp
                    @foreach($projectsArray as $index => $project)
                        <div class="project-input-group flex items-center">
                            <x-text-input name="projects[]" type="text" class="mt-1 block w-full" value="{{ trim($project) }}" />
                            <button type="button" class="remove-project ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="project-input-group flex items-center">
                        <x-text-input name="projects[]" type="text" class="mt-1 block w-full" placeholder="e.g. Portfolio Website" />
                        <button type="button" class="remove-project ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-project" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-sm">
                {{ __('+ Add Project') }}
            </button>
            <x-input-error class="mt-2" :messages="$errors->get('projects')" />
        </div>

        <div>
            <x-input-label for="certifications" :value="__('Certifications')" />
            <div id="certifications-container" class="space-y-2">
                @if($user->certifications)
                    @php
                        $certificationsArray = explode(',', $user->certifications);
                    @endphp
                    @foreach($certificationsArray as $index => $certification)
                        <div class="certification-input-group flex items-center">
                            <x-text-input name="certifications[]" type="text" class="mt-1 block w-full" value="{{ trim($certification) }}" />
                            <button type="button" class="remove-certification ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="certification-input-group flex items-center">
                        <x-text-input name="certifications[]" type="text" class="mt-1 block w-full" placeholder="e.g. AWS Certified Developer" />
                        <button type="button" class="remove-certification ml-2 px-2 py-1 bg-red-500 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-certification" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-sm">
                {{ __('+ Add Certification') }}
            </button>
            <x-input-error class="mt-2" :messages="$errors->get('certifications')" />
        </div>
        <div>
            <x-input-label for="github_url" :value="__('GitHub URL')" />
            <x-text-input id="github_url" name="github_url" type="text" class="mt-1 block w-full" :value="old('github_url', $user->github_url)" autocomplete="github_url" />
            <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" autocomplete="image" />
            @if($user->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Current Profile Image" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200" />
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div>
            <x-input-label for="industry" :value="__('Industry')" />
            <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry', $user->industry)" autocomplete="industry" />
            <x-input-error class="mt-2" :messages="$errors->get('industry')" />
        </div>

        <div>
            <x-input-label for="banner" :value="__('Banner')" />
            <input id="banner" name="banner" type="file" class="mt-1 block w-full" autocomplete="banner" />
            @if($user->banner)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->banner) }}" alt="Current Banner" class="w-full h-24 object-cover rounded-md" />
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('banner')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-input id="bio" name="bio" type="text" class="mt-1 block w-full" :value="old('bio', $user->bio)" autocomplete="bio" />
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Skills functionality
        const container = document.getElementById('skills-container');
        const addButton = document.getElementById('add-skill');

        // Add new skill input
        addButton.addEventListener('click', function() {
            const newSkillGroup = document.createElement('div');
            newSkillGroup.className = 'skill-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'skills[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. JavaScript';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-skill ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newSkillGroup.appendChild(input);
            newSkillGroup.appendChild(removeButton);
            container.appendChild(newSkillGroup);
        });

        // Remove skill input (using event delegation)
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-skill')) {
                const skillGroup = e.target.closest('.skill-input-group');
                // Only remove if there's more than one skill input
                if (container.querySelectorAll('.skill-input-group').length > 1) {
                    skillGroup.remove();
                }
            }
        });

        // Programming Languages functionality
        const languagesContainer = document.getElementById('languages-container');
        const addLanguageButton = document.getElementById('add-language');

        // Add new programming language input
        addLanguageButton.addEventListener('click', function() {
            const newLanguageGroup = document.createElement('div');
            newLanguageGroup.className = 'language-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'programming_languages[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. Python';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-language ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newLanguageGroup.appendChild(input);
            newLanguageGroup.appendChild(removeButton);
            languagesContainer.appendChild(newLanguageGroup);
        });

        // Remove programming language input (using event delegation)
        languagesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-language')) {
                const languageGroup = e.target.closest('.language-input-group');
                // Only remove if there's more than one language input
                if (languagesContainer.querySelectorAll('.language-input-group').length > 1) {
                    languageGroup.remove();
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Skills functionality
        const container = document.getElementById('skills-container');
        const addButton = document.getElementById('add-skill');

        // Add new skill input
        addButton.addEventListener('click', function() {
            const newSkillGroup = document.createElement('div');
            newSkillGroup.className = 'skill-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'skills[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. JavaScript';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-skill ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newSkillGroup.appendChild(input);
            newSkillGroup.appendChild(removeButton);
            container.appendChild(newSkillGroup);
        });

        // Remove skill input (using event delegation)
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-skill')) {
                const skillGroup = e.target.closest('.skill-input-group');
                // Only remove if there's more than one skill input
                if (container.querySelectorAll('.skill-input-group').length > 1) {
                    skillGroup.remove();
                }
            }
        });

        // Programming Languages functionality
        const languagesContainer = document.getElementById('languages-container');
        const addLanguageButton = document.getElementById('add-language');

        // Add new programming language input
        addLanguageButton.addEventListener('click', function() {
            const newLanguageGroup = document.createElement('div');
            newLanguageGroup.className = 'language-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'programming_languages[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. Python';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-language ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newLanguageGroup.appendChild(input);
            newLanguageGroup.appendChild(removeButton);
            languagesContainer.appendChild(newLanguageGroup);
        });

        // Remove programming language input (using event delegation)
        languagesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-language')) {
                const languageGroup = e.target.closest('.language-input-group');
                // Only remove if there's more than one language input
                if (languagesContainer.querySelectorAll('.language-input-group').length > 1) {
                    languageGroup.remove();
                }
            }
        });

        // Projects functionality
        const projectsContainer = document.getElementById('projects-container');
        const addProjectButton = document.getElementById('add-project');

        // Add new project input
        addProjectButton.addEventListener('click', function() {
            const newProjectGroup = document.createElement('div');
            newProjectGroup.className = 'project-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'projects[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. Portfolio Website';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-project ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newProjectGroup.appendChild(input);
            newProjectGroup.appendChild(removeButton);
            projectsContainer.appendChild(newProjectGroup);
        });

        // Remove project input (using event delegation)
        projectsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-project')) {
                const projectGroup = e.target.closest('.project-input-group');
                // Only remove if there's more than one project input
                if (projectsContainer.querySelectorAll('.project-input-group').length > 1) {
                    projectGroup.remove();
                }
            }
        });

        // Certifications functionality
        const certificationsContainer = document.getElementById('certifications-container');
        const addCertificationButton = document.getElementById('add-certification');

        // Add new certification input
        addCertificationButton.addEventListener('click', function() {
            const newCertificationGroup = document.createElement('div');
            newCertificationGroup.className = 'certification-input-group flex items-center mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'certifications[]';
            input.className = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
            input.placeholder = 'e.g. AWS Certified Developer';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-certification ml-2 px-2 py-1 bg-red-500 text-white rounded-md';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';

            newCertificationGroup.appendChild(input);
            newCertificationGroup.appendChild(removeButton);
            certificationsContainer.appendChild(newCertificationGroup);
        });

        // Remove certification input (using event delegation)
        certificationsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-certification')) {
                const certificationGroup = e.target.closest('.certification-input-group');
                // Only remove if there's more than one certification input
                if (certificationsContainer.querySelectorAll('.certification-input-group').length > 1) {
                    certificationGroup.remove();
                }
            }
        });
    });
</script>
