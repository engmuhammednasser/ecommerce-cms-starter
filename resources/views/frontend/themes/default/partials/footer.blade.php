<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto grid max-w-6xl gap-6 px-6 py-8 md:grid-cols-[1fr_auto] md:items-center">
        <div class="space-y-2">
            @if (setting('footer.show_store_name', '1') === '1')
                <div class="font-semibold text-slate-950">{{ $storeName ?? config('app.name', 'Laravel') }}</div>
            @endif

            @if (setting('footer.text', $footerText ?? null))
                <p class="max-w-xl text-sm text-slate-500">{{ setting('footer.text', $footerText ?? '') }}</p>
            @endif
        </div>

        @include('frontend.themes.default.partials.navigation', [
            'items' => $footerMenuItems ?? collect(),
            'label' => 'Footer navigation',
        ])
    </div>
</footer>
