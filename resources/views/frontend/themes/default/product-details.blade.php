@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    @php
        $hasVariants = $variants->isNotEmpty();
        // JSON-encode variants for JS consumption
        $variantsJson = $variants->map(fn($v) => [
            'id' => $v->id,
            'label' => $v->label(),
            'sku' => $v->sku,
            'price' => $v->price !== null ? (float) $v->price : (float) $product->price,
            'sale_price' => $v->sale_price !== null ? (float) $v->sale_price : ($product->sale_price ? (float) $product->sale_price : null),
            'stock' => $v->stock_quantity,
        ])->toJson();
    @endphp

    @php
        /**
         * Product detail image rendering (TASK-055D):
         * 1. mainImage — Media record
         * 2. gallery images (ProductImage records)
         * 3. hoverImage shown as second image if no gallery
         * 4. Compact neutral fallback
         */
        $mainMediaImage = ($product->relationLoaded('mainImage') && $product->mainImage) ? $product->mainImage : null;
        $galleryImages  = $product->images ?? collect();
        $hoverMediaImage = ($product->relationLoaded('hoverImage') && $product->hoverImage) ? $product->hoverImage : null;
    @endphp

    <article class="mx-auto grid max-w-6xl gap-10 px-6 py-10 lg:grid-cols-[1.05fr_0.95fr]">
    <div class="space-y-4">
        {{-- Main image (Media library) takes first slot --}}
        @if ($mainMediaImage)
            <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-sm">
                <img src="{{ $mainMediaImage->url() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            </div>
        @endif

        {{-- Gallery images (legacy ProductImage) --}}
        @forelse ($galleryImages as $image)
            <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-sm">
                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text ?: $product->name }}" class="h-full w-full object-cover">
            </div>
        @empty
            {{-- If no mainImage either, show hover image or fallback --}}
            @if (!$mainMediaImage)
                @if ($hoverMediaImage)
                    <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-sm">
                        <img src="{{ $hoverMediaImage->url() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    </div>
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-3xl border border-slate-200 bg-slate-100 text-slate-400 text-sm shadow-sm">
                        {{ setting('catalog.no_product_image_label', 'No image available') }}
                    </div>
                @endif
            @endif
        @endforelse
    </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:p-8">
            @if ($product->category)
                <a href="{{ route('catalog.categories.show', $product->category) }}" class="text-sm font-semibold uppercase tracking-wide text-slate-500 hover:text-slate-900">
                    {{ $product->category->name }}
                </a>
            @endif

            <div class="mt-5" id="price-display">
                @include('frontend.themes.default.components.price', [
                    'price' => $product->price,
                    'salePrice' => !$hasVariants ? $product->sale_price : null,
                    'size' => 'lg',
                ])
            </div>

            <form method="POST" action="{{ route('cart.items.store', $product) }}" class="mt-6 space-y-4">
                @csrf

                @if ($hasVariants)
                    <div>
                        <label for="variant_id" class="block text-sm font-medium text-slate-600 mb-1">
                            {{ setting('catalog.variant_label', 'Select Option') }}
                        </label>
                        <select id="variant_id" name="variant_id" required class="w-full rounded-xl border border-slate-300 px-3 py-3 bg-white">
                            <option value="">Choose an option...</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}"
                                    data-price="{{ $variant->price !== null ? (float) $variant->price : (float) $product->price }}"
                                    data-sale-price="{{ $variant->sale_price !== null ? (float) $variant->sale_price : ($product->sale_price ? (float) $product->sale_price : '') }}"
                                    data-stock="{{ $variant->stock_quantity }}"
                                    {{ $variant->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    {{ $variant->label() }}{{ $variant->stock_quantity <= 0 ? ' — Out of stock' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex flex-wrap items-end gap-3">
                    <label class="block text-sm">
                        <span class="mb-1 block text-slate-600">{{ setting('cart.quantity_label', 'Quantity') }}</span>
                        <input type="number" name="quantity" value="1" min="1" class="w-24 rounded-xl border border-slate-300 px-3 py-3">
                    </label>
                    <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                        {{ setting('cart.add_label', 'Add to cart') }}
                    </button>
                </div>
            </form>

            @if ($product->short_description)
                <p class="mt-6 leading-7 text-slate-700">{{ $product->short_description }}</p>
            @endif

            @if ($product->description)
                <div class="mt-6 max-w-none leading-8 text-slate-700">
                    {!! nl2br(e($product->description)) !!}
                </div>
            @endif

            <dl class="mt-6 grid gap-3 border-t border-slate-200 pt-6 text-sm">
                @if ($product->sku)
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-500">{{ setting('catalog.sku_label', 'SKU') }}</dt>
                        <dd id="sku-display">{{ $product->sku }}</dd>
                    </div>
                @endif
                @if (!$hasVariants)
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-500">{{ setting('catalog.stock_label', 'Stock') }}</dt>
                        <dd>{{ $product->stock_quantity }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </article>

    @if ($hasVariants)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('variant_id');
            const priceDisplay = document.getElementById('price-display');

            function format(n) { return parseFloat(n).toFixed(2); }

            select.addEventListener('change', function () {
                const opt = select.options[select.selectedIndex];
                if (!opt || !opt.value) {
                    priceDisplay.innerHTML = `<div class="text-3xl font-semibold text-slate-950">{{ number_format((float) $product->price, 2) }}</div>`;
                    return;
                }
                const price = parseFloat(opt.getAttribute('data-price'));
                const salePrice = opt.getAttribute('data-sale-price');

                if (salePrice && salePrice !== '') {
                    const sale = parseFloat(salePrice);
                    priceDisplay.innerHTML = `<div class="flex items-center gap-3"><span class="text-3xl font-semibold text-slate-950">${format(sale)}</span><span class="text-slate-400 line-through">${format(price)}</span></div>`;
                } else {
                    priceDisplay.innerHTML = `<div class="text-3xl font-semibold text-slate-950">${format(price)}</div>`;
                }

                const skuDisplay = document.getElementById('sku-display');
                if (skuDisplay) {
                    const sku = opt.getAttribute('data-sku');
                    if (sku) skuDisplay.textContent = sku;
                }
            });
        });
    </script>
    @endif
@endsection
