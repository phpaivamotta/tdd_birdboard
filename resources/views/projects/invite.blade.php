<div class="card flex flex-col mt-3">
    <h3 class="text-xl font-semibold py-4 -ml-5 border-l-4 border-blue-300 pl-4 mb-4">
        Invite a user
    </h3>

    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email"
                class="placeholder:text-white border border-gray bg-gray-500 rounded w-full p-2"
                placeholder="Email address">
        </div>

        <button type="submit" class="button">
            Invite
        </button>
    </form>

    @include('errors', ['bag' => 'invitations'])
</div>
