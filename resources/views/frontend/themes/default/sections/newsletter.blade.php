<section class="mx-auto max-w-6xl px-6 py-12">
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm lg:p-10">
        @if ($section->title)
            <h2 class="text-3xl font-semibold tracking-tight text-slate-950">{{ $section->title }}</h2>
        @endif
        @if ($section->content)
            <p class="mt-3 max-w-2xl leading-7 text-slate-600">{{ $section->content }}</p>
        @endif
        @if ($section->button_text && $section->button_url)
            <a href="{{ $section->button_url }}" class="mt-6 inline-flex rounded-full border border-slate-950 px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-slate-950 hover:text-white">
                {{ $section->button_text }}
            </a>
        @endif
    </div>
</section>
