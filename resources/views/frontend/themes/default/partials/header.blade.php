<header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-4">
        <a href="{{ url('/') }}" class="text-lg font-semibold tracking-wide text-slate-950 flex items-center gap-2">
            @if (setting('general.logo'))
                <img src="{{ asset('storage/' . setting('general.logo')) }}" alt="{{ $storeName ?? config('app.name', 'Laravel') }}" class="h-8 w-auto">
            @else
                {{ $storeName ?? config('app.name', 'Laravel') }}
            @endif
        </a>

        <div class="flex items-center gap-5">
            @include('frontend.themes.default.partials.navigation', [
                'items' => $headerMenuItems ?? collect(),
            ])

            <a href="{{ route('cart.show') }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:bg-slate-950 hover:text-white">
                {{ setting('cart.title', 'Cart') }}
            </a>
        </div>
    </div>
</header>
