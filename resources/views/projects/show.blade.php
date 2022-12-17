<x-app-layout>
    <div>
        <h1 class="font-semibold text-2xl">{{ $project->title }}</h1>
        <p class="text-sm mt-2">{{ $project->description }}</p>

        <a class="text-xs text-blue-300" href="{{ route('projects.index') }}">Go back</a>
    </div>
</x-app-layout>
