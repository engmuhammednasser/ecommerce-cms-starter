@props(['category'])

<a href="{{ route('catalog.categories.show', $category) }}" {{ $attributes->merge(['class' => 'group relative block overflow-hidden rounded-3xl bg-slate-900 aspect-[4/3]']) }}>
    @if ($category->image_path)
        <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="absolute inset-0 h-full w-full object-cover opacity-60 transition duration-500 group-hover:scale-105 group-hover:opacity-50">
    @else
        <div class="absolute inset-0 bg-slate-800 transition duration-500 group-hover:bg-slate-700"></div>
    @endif
    
    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
        <h3 class="text-2xl font-bold text-white sm:text-3xl">{{ $category->name }}</h3>
        <span class="mt-4 inline-flex translate-y-4 items-center gap-2 rounded-full bg-white/20 px-6 py-2.5 text-sm font-medium text-white opacity-0 backdrop-blur transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
            Shop Collection
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </span>
    </div>
</a>
