<x-app-layout>
    <header class="flex items-end justify-between my-6">
        <p class="text-blue-300 text-sm">
            <a href="{{ route('projects.index') }}">My Projects</a> &nbsp;/&nbsp; {{ $project->title }}
        </p>

        <a class="text-xs" href="{{ route('projects.create') }}">
            <h2 class="button">
                Add Project
            </h2>
        </a>

    </header>

    <main>
        <div class="lg:flex">

            <div class="lg:w-3/4 lg:mr-4 mb-6 lg:mb-0">
                <div>
                    <h2 class="text-lg text-gray-200 mb-2">Tasks</h2>

                    <div class="card mb-4">Lorem Isum notes...</div>
                    <div class="card mb-4">Lorem Isum notes...</div>
                    <div class="card mb-4">Lorem Isum notes...</div>
                    <div class="card">Lorem Isum notes...</div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg text-gray-200 mb-2">General Notes</h2>
                    <textarea class="card w-full" style="min-height: 200px;">Lorem Ipsum notes...</textarea>
                </div>
            </div>

            <div class="lg:w-1/4">
                <x-card :project="$project" />

                {{-- <a class="text-xs text-blue-300" href="{{ route('projects.index') }}">Go back</a> --}}
            </div>

        </div>

    </main>

</x-app-layout>
