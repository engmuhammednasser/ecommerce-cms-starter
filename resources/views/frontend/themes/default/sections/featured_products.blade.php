<section class="mx-auto max-w-6xl px-6 py-12">
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            @if ($section->title)
                <h2 class="text-3xl font-semibold tracking-tight text-slate-950">{{ $section->title }}</h2>
            @endif
            @if ($section->subtitle)
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">{{ $section->subtitle }}</p>
            @endif
        </div>
        @if ($section->button_text && $section->button_url)
            <a href="{{ $section->button_url }}" class="rounded-full border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:bg-slate-950 hover:text-white">{{ $section->button_text }}</a>
        @endif
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (($featuredProducts ?? collect()) as $product)
            @include('frontend.themes.default.partials.catalog.product-card', ['product' => $product])
        @endforeach
    </div>
</section>
