@props(['product'])

@php
    /**
     * Image priority chain (TASK-055D):
     * 1. mainImage  — Media record assigned via admin (TASK-055A)
     * 2. primaryImage — first ProductImage from the gallery (legacy)
     * 3. store.default_product_image setting
     * 4. Compact neutral fallback placeholder
     */
    $mainImgUrl = null;
    if ($product->relationLoaded('mainImage') && $product->mainImage) {
        $mainImgUrl = $product->mainImage->url();
    } elseif ($product->relationLoaded('primaryImage') && $product->primaryImage) {
        $mainImgUrl = asset('storage/' . $product->primaryImage->image_path);
    } elseif ($default = setting('store.default_product_image')) {
        $mainImgUrl = asset('storage/' . $default);
    }

    /**
     * Hover image — Media record from hoverImage relation (TASK-055A).
     * Falls back to null (no hover effect applied).
     */
    $hoverImgUrl = null;
    if ($product->relationLoaded('hoverImage') && $product->hoverImage) {
        $hoverImgUrl = $product->hoverImage->url();
    }

    $imgAlt = $product->name;
@endphp

<div {{ $attributes->merge(['class' => 'group flex flex-col rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md']) }}>
    <a href="{{ route('catalog.products.show', $product) }}" class="relative block aspect-[4/3] overflow-hidden rounded-t-3xl bg-slate-100">

        @if ($mainImgUrl)
            <img src="{{ $mainImgUrl }}"
                 alt="{{ $imgAlt }}"
                 class="h-full w-full object-cover transition duration-500 {{ $hoverImgUrl ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}">

            @if ($hoverImgUrl)
                <img src="{{ $hoverImgUrl }}"
                     alt="{{ $imgAlt }}"
                     class="absolute inset-0 h-full w-full object-cover opacity-0 transition duration-500 group-hover:opacity-100">
            @endif
        @else
            {{-- Compact neutral fallback — no oversized icon --}}
            <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400 text-xs font-medium tracking-wide uppercase">
                No image
            </div>
        @endif

        @if ($product->sale_price)
            <div class="absolute left-4 top-4">
                @include('frontend.themes.default.components.badge', ['type' => 'danger', 'text' => 'Sale'])
            </div>
        @elseif ($product->featured)
            <div class="absolute left-4 top-4">
                @include('frontend.themes.default.components.badge', ['type' => 'info', 'text' => 'Featured'])
            </div>
        @endif

        @if ($product->stock_quantity <= 0 && !$product->hasVariants())
            <div class="absolute inset-0 flex items-center justify-center bg-white/60 backdrop-blur-sm">
                <span class="rounded-full bg-slate-900 px-4 py-2 text-sm font-bold text-white">Out of stock</span>
            </div>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        @if ($product->category)
            <a href="{{ route('catalog.categories.show', $product->category) }}" class="mb-1 text-xs font-semibold uppercase tracking-wider text-slate-500 hover:text-slate-900">
                {{ $product->category->name }}
            </a>
        @endif

        <h3 class="mb-2 text-sm font-bold text-slate-900 leading-snug">
            <a href="{{ route('catalog.products.show', $product) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>

        <div class="mt-auto pt-3">
            @include('frontend.themes.default.components.price', [
                'price' => $product->price,
                'salePrice' => $product->sale_price,
            ])
        </div>
    </div>
</div>
