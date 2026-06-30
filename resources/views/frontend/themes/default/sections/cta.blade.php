<section class="mx-auto max-w-6xl px-6 py-12">
    <div class="rounded-3xl bg-slate-950 p-8 text-white shadow-xl lg:p-10">
        @if ($section->subtitle)
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-300">{{ $section->subtitle }}</p>
        @endif
        @if ($section->title)
            <h2 class="mt-3 text-3xl font-semibold tracking-tight">{{ $section->title }}</h2>
        @endif
        @if ($section->content)
            <p class="mt-3 max-w-3xl leading-7 text-slate-300">{{ $section->content }}</p>
        @endif
        @if ($section->button_text && $section->button_url)
            <a href="{{ $section->button_url }}" class="mt-6 inline-flex rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-slate-200">
                {{ $section->button_text }}
            </a>
        @endif
    </div>
</section>
