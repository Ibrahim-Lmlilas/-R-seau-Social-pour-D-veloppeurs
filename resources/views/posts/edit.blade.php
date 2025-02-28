<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Post') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $post->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description', $post->description)" required />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Hashtags -->
                            <div>
                                <x-input-label for="hashtags" :value="__('Hashtags')" />
                                <x-text-input id="hashtags" class="block mt-1 w-full" type="text" name="hashtags" :value="old('hashtags', $post->hashtags)" />
                                <x-input-error :messages="$errors->get('hashtags')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="line" @if($post->type === 'line') selected @endif>Line</option>
                                    <option value="code" @if($post->type === 'code') selected @endif>Code</option>
                                    <option value="image" @if($post->type === 'image') selected @endif>Image</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Line (if type is line) -->
                            <div id="line-field" @if($post->type !== 'line') style="display: none;" @endif>
                                <x-input-label for="line" :value="__('Line')" />
                                <x-text-input id="line" class="block mt-1 w-full" type="text" name="line" :value="old('line', $post->line)" />
                                <x-input-error :messages="$errors->get('line')" class="mt-2" />
                            </div>

                            <!-- Code (if type is code) -->
                            <div id="code-field" @if($post->type !== 'code') style="display: none;" @endif>
                                <x-input-label for="code" :value="__('Code')" />
                                <textarea id="code" name="code" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('code', $post->code) }}</textarea>
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <!-- Image (if type is image) -->
                            <div id="image-field" @if($post->type !== 'image') style="display: none;" @endif>
                                <x-input-label for="image" :value="__('Image')" />
                                <input id="image" type="file" name="image" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="mt-2 rounded-md" width="200" />
                                @endif
                            </div>

                            <div class="flex items-center justify-end">
                                <x-primary-button class="ml-4">
                                    {{ __('Update') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        const typeSelect = document.getElementById('type');
        const lineField = document.getElementById('line-field');
        const codeField = document.getElementById('code-field');
        const imageField = document.getElementById('image-field');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'line') {
                lineField.style.display = 'block';
                codeField.style.display = 'none';
                imageField.style.display = 'none';
            } else if (this.value === 'code') {
                lineField.style.display = 'none';
                codeField.style.display = 'block';
                imageField.style.display = 'none';
            } else if (this.value === 'image') {
                lineField.style.display = 'none';
                codeField.style.display = 'none';
                imageField.style.display = 'block';
            } else {
                lineField.style.display = 'none';
                codeField.style.display = 'none';
                imageField.style.display = 'none';
            }
        });
    </script>
</body>
</html>
