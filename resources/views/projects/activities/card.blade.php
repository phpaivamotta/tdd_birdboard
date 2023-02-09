<div class="card mt-2 text-xs">
    <ul class="space-y-1">
        @foreach ($project->activities as $activity)
            <li>
                @include("projects.activities.{$activity->description}")
                <span class="text-gray-400">
                    {{ $activity->created_at->diffForHumans(null, true) }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
