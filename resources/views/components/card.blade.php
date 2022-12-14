@props(['project'])

<div {{ $attributes }}>
    <div class="card" style="height: 200px;">
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
