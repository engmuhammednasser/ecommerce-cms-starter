<header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur">
    @if (setting('header.announcement_text'))
        <div class="bg-slate-950 px-6 py-2 text-center text-sm font-medium text-white">
            {{ setting('header.announcement_text') }}
        </div>
    @endif

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

            @auth('customer')
                <a href="{{ route('customer.dashboard') }}" class="text-sm font-semibold text-slate-700 transition hover:text-slate-950">
                    My Account
                </a>
            @else
                <a href="{{ route('customer.login') }}" class="text-sm font-semibold text-slate-700 transition hover:text-slate-950">
                    Sign in
                </a>
            @endauth

            @if (setting('header.show_cart_link', '1') === '1')
                <a href="{{ route('cart.show') }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:bg-slate-950 hover:text-white">
                    {{ setting('header.cart_label', setting('cart.title', 'Cart')) }}
                </a>
            @endif
        </div>
    </div>
</header>
