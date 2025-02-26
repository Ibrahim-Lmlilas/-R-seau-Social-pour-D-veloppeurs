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


        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
        <div>
            <x-input-label for="github_link" :value="__('GitHub Link')" />
            <x-text-input id="github_link" name="github_link" type="text" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:ring-opacity-50" :value="old('github_link', $user->github_link)" required autofocus autocomplete="github_link" />
            <x-input-error class="mt-2" :messages="$errors->get('github_link')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required autofocus autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="technical_skills" :value="__('Technical Skills')" />
            <x-text-input id="technical_skills" name="technical_skills" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:ring-opacity-50" :value="old('technical_skills', $user->technical_skills)" required autofocus autocomplete="technical_skills"/>
            <x-input-error class="mt-2" :messages="$errors->get('technical_skills')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <div id="bio" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600 focus:ring-opacity-50">
                {!! old('bio', $user->bio) !!}
            </div>
            <input type="hidden" id="bio_content" name="bio" value="{{ old('bio', $user->bio) }}">
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>
        <div>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            var quill = new Quill('#bio', {
                theme: 'snow'
            });
            quill.on('text-change', function(delta, oldDelta, source) {
                document.getElementById('bio_content').value = quill.root.innerHTML;
            });
             quill.setContents(<?php echo json_encode(old('bio', $user->bio)); ?>);
        </script>
        </div>
        <div>


            <x-input-label for="completed_projects" :value="__('Completed Projects')" />
            <x-text-input id="completed_projects" name="completed_projects" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:ring-opacity-50" :value="old('completed_projects', $user->completed_projects)" required autofocus autocomplete="completed_projects"/>
            <x-input-error class="mt-2" :messages="$errors->get('completed_projects')" />
        </div>

        <div>
            <x-input-label for="certifications" :value="__('Certifications')" />
            <x-text-input id="certifications" name="certifications" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:ring-opacity-50" :value="old('certifications', $user->certifications)" required autofocus autocomplete="certifications"/>
            <x-input-error class="mt-2" :messages="$errors->get('certifications')" />
        </div>
        <img src="{{asset('storege/'.$user->photo)}}" alt="">
        <div>
            <x-input-label for="photo" :value="__('Photo')"  />
            <input type="file" id="photo" name="photo" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:ring-opacity-50" :value="old('photo', $user->photo)" required autofocus autocomplete="photo" />
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
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
