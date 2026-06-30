<section class="mx-auto max-w-6xl px-6 py-10">
    <div class="grid overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:grid-cols-[1fr_24rem]">
        <div class="space-y-4 p-8 lg:p-10">
            @if ($section->subtitle)
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ $section->subtitle }}</p>
            @endif
            @if ($section->title)
                <h2 class="text-3xl font-semibold tracking-tight text-slate-950">{{ $section->title }}</h2>
            @endif
            @if ($section->content)
                <p class="leading-7 text-slate-600">{{ $section->content }}</p>
            @endif
            @if ($section->button_text && $section->button_url)
                <a href="{{ $section->button_url }}" class="inline-flex rounded-full border border-slate-950 px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-slate-950 hover:text-white">
                    {{ $section->button_text }}
                </a>
            @endif
        </div>
        @if ($section->image)
            <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="h-full min-h-64 w-full object-cover">
        @endif
    </div>
</section>
