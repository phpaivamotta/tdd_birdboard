<x-app-layout>

    <header class="flex items-center justify-between my-6">
        <p class="text-blue-300 text-sm">My Projects</p>

        <a class="text-xs" href="{{ route('projects.create') }}">
            <h2 class="button">
                New Project
            </h2>
        </a>

    </header>

    <main class="lg:file:flex lg:file:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:file:w-1/3 px-3 pb-6">
                <div class="bg-gray-700 rounded-lg shadow p-5" style="height: 200px;">
                    <h3 class="text-xl font-semibold py-4 -ml-5 border-l-4 border-blue-300 pl-4 mb-4">
                        <a href="{{ $project->path() }}">
                            {{ $project->title }}
                        </a>
                    </h3>

                    <div class="text-sm text-gray-400">
                        {{ \Illuminate\Support\Str::limit($project->description, 100) }}
                    </div>
                </div>
            </div>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </main>
</x-app-layout>
