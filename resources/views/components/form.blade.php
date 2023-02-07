@props(['project', 'buttonText' => 'create'])

<!-- Title -->
<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $project->title)" required autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="description" :value="__('Description')" />

    <textarea
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full dark:placeholder-gray-400"
        name="description" id="description" rows="10" placeholder="Type project description..." required>{{ old('description', $project->description) }}</textarea>

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <a class="text-xs text-blue-300" href="{{ $project->path() }}">
        Cancel
    </a>
    <x-primary-button class="ml-3">
        {{ __($buttonText) }}
    </x-primary-button>
</div>
