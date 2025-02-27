<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Send Connection Request') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Send a connection request to this user.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('connections.send', $user) }}" class="mt-6 space-y-6">
        @csrf

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Send Request') }}</x-primary-button>
        </div>
    </form>
</section>
