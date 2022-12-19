<x-app-layout>

    <header class="flex items-end justify-between my-6">
        <p class="text-blue-300 text-sm">My Projects</p>

        <a class="text-xs" href="{{ route('projects.create') }}">
            <h2 class="button">
                Add Project
            </h2>
        </a>

    </header>

    <main class="lg:file:flex lg:file:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <x-card class="px-3 pb-6" :project="$project"/>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </main>
</x-app-layout>
