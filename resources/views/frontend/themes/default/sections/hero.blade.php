<section class="bg-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-16 lg:grid-cols-[1fr_30rem] lg:items-center lg:py-20">
        <div class="space-y-7">
            @if ($section->subtitle)
                <p class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold uppercase tracking-wide text-slate-600">{{ $section->subtitle }}</p>
            @endif
            @if ($section->title)
                <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">{{ $section->title }}</h1>
            @endif
            @if ($section->content)
                <p class="max-w-2xl text-lg leading-8 text-slate-600">{{ $section->content }}</p>
            @endif
            @if ($section->button_text && $section->button_url)
                <a href="{{ $section->button_url }}" class="inline-flex rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700">
                    {{ $section->button_text }}
                </a>
            @endif
        </div>
        @if ($section->image)
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-xl">
                <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="aspect-[4/3] h-full w-full object-cover">
            </div>
        @endif
    </div>
</section>
