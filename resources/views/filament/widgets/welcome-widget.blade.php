<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between gap-x-3">
            <div class="flex items-center gap-x-3">
                <img src="{{ asset('images/logo.webp') }}" alt="Mandi & Grill" style="width: 120px; height: 120px;" class="rounded-full object-cover shadow-lg border-2 border-amber-500/20">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                        {{ __('Welcome') }}, {{ auth()->user()->full_name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ auth()->user()->roles->pluck('name')->map(fn($role) => __($role))->join(', ') ?: __('User') }}
                    </p>
                </div>
            </div>

            <form action="{{ filament()->getLogoutUrl() }}" method="post" class="my-auto">
                @csrf
                <x-filament::button
                    type="submit"
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    labeled-from="md"
                    tag="button"
                >
                    {{ __('Sign out') }}
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
