<section class="mx-auto max-w-6xl px-6 py-12">
    <div class="mb-8">
        @if ($section->title)
            <h2 class="text-3xl font-semibold tracking-tight text-slate-950">{{ $section->title }}</h2>
        @endif
        @if ($section->subtitle)
            <p class="mt-2 max-w-2xl leading-7 text-slate-600">{{ $section->subtitle }}</p>
        @endif
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (($categories ?? collect())->take(6) as $category)
            <a href="{{ route('catalog.categories.show', $category) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-105">
                @endif
                <div class="p-5">
                    <h3 class="font-semibold text-slate-950 group-hover:text-slate-700">{{ $category->name }}</h3>
                    @if ($category->description)
                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ $category->description }}</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</section>
