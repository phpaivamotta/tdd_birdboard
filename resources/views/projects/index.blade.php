<x-app-layout>

    <div class="flex items-center justify-between mb-3">
        <a class="text-xs" href="{{ route('projects.create') }}">
            <p class="text-blue-300">New Project</p>
        </a>
    </div>

    <ul>
        @forelse ($projects as $project)
            <li class="text-sm list-disc">
                <a href="{{ $project->path() }}">
                    {{ $project->title }}
                </a>
            </li>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul>
</x-app-layout>
