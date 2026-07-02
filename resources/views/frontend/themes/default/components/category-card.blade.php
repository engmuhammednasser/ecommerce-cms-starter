@props(['category'])

@php
    /**
     * Image priority chain (TASK-055D):
     * 1. coverImage — Media record assigned via admin (TASK-055A)
     * 2. image      — legacy string path field
     * 3. store.default_category_image setting
     * 4. Neutral dark fallback
     */
    $imgUrl = null;
    if ($category->relationLoaded('coverImage') && $category->coverImage) {
        $imgUrl = $category->coverImage->url();
    } elseif ($category->image) {
        $imgUrl = asset('storage/' . $category->image);
    } elseif ($default = setting('store.default_category_image')) {
        $imgUrl = asset('storage/' . $default);
    }
@endphp

<a href="{{ route('catalog.categories.show', $category) }}" {{ $attributes->merge(['class' => 'group relative block overflow-hidden rounded-3xl bg-slate-900 aspect-[4/3]']) }}>
    @if ($imgUrl)
        <img src="{{ $imgUrl }}" alt="{{ $category->name }}" class="absolute inset-0 h-full w-full object-cover opacity-60 transition duration-500 group-hover:scale-105 group-hover:opacity-50">
    @else
        <div class="absolute inset-0 bg-slate-800 transition duration-500 group-hover:bg-slate-700"></div>
    @endif

    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
        <h3 class="text-lg font-bold text-white sm:text-xl leading-tight">{{ $category->name }}</h3>
        <span class="mt-3 inline-flex translate-y-4 items-center gap-2 rounded-full bg-white/20 px-5 py-2 text-xs font-medium text-white opacity-0 backdrop-blur transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
            Shop Collection
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </span>
    </div>
</a>
