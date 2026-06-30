@php
    $image = $product->primaryImage?->path;
    $price = $product->sale_price ?: $product->price;
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
    @if ($image)
        <a href="{{ route('catalog.products.show', $product) }}" class="block aspect-[4/3] overflow-hidden bg-slate-100">
            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->primaryImage?->alt_text ?: $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        </a>
    @else
        <a href="{{ route('catalog.products.show', $product) }}" class="flex aspect-[4/3] items-center justify-center bg-slate-100 text-sm text-slate-500">
            {{ setting('catalog.no_product_image_label', 'No image available') }}
        </a>
    @endif

    <div class="flex flex-1 flex-col space-y-4 p-5">
        <div>
            @if ($product->category)
                <a href="{{ route('catalog.categories.show', $product->category) }}" class="text-xs font-semibold uppercase tracking-wide text-slate-500 hover:text-slate-900">
                    {{ $product->category->name }}
                </a>
            @endif
            <h2 class="mt-2 text-lg font-semibold leading-snug text-slate-950">
                <a href="{{ route('catalog.products.show', $product) }}" class="hover:text-slate-700">
                    {{ $product->name }}
                </a>
            </h2>
        </div>

        @if ($product->short_description)
            <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $product->short_description }}</p>
        @endif

        <div class="mt-auto flex items-center justify-between gap-3">
            <div class="text-lg font-semibold text-slate-950">{{ number_format((float) $price, 2) }}</div>
            @if ($product->sale_price)
                <div class="text-sm text-slate-400 line-through">{{ number_format((float) $product->price, 2) }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('cart.items.store', $product) }}">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full rounded-full bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                {{ setting('cart.add_label', 'Add to cart') }}
            </button>
        </form>
    </div>
</article>
