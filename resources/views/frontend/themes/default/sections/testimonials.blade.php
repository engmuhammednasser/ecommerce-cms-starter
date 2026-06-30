<section class="mx-auto max-w-6xl px-6 py-12">
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm lg:p-10">
        @if ($section->title)
            <h2 class="text-3xl font-semibold tracking-tight text-slate-950">{{ $section->title }}</h2>
        @endif
        @if ($section->content)
            <blockquote class="mt-6 max-w-4xl text-xl leading-9 text-slate-700">{{ $section->content }}</blockquote>
        @endif
        @if ($section->subtitle)
            <p class="mt-4 text-sm font-semibold text-slate-500">{{ $section->subtitle }}</p>
        @endif
    </div>
</section>
