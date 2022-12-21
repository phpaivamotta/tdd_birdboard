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

                    @foreach ($project->tasks as $task)

                        <div class="card mb-4">

                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" class="w-full bg-gray-700 ml-1 {{ $task->completed ? 'text-gray-500' : '' }}"></input>
                                    <input name="completed" type="checkbox" {{ $task->completed ? 'checked' : '' }} class="rounded-sm text-indigo-600" onChange="this.form.submit()">
                                </div>

                            </form>

                        </div>

                    @endforeach

                    <form action="{{ $project->path() . '/tasks' }}" method="POST">
                        @csrf
                        <input name="body" class="text-gray-400 card w-full" placeholder="Add task..." />
                    </form>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg text-gray-200 mb-2">General Notes</h2>
                    <textarea class="card w-full text-gray-400" style="min-height: 200px;">Lorem Ipsum notes...</textarea>
                </div>
            </div>

            <div class="lg:w-1/4">
                <x-card :project="$project" />
            </div>

        </div>

    </main>

</x-app-layout>
