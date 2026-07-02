@props(['product'])

<div {{ $attributes->merge(['class' => 'group flex flex-col rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md']) }}>
    <a href="{{ route('catalog.products.show', $product) }}" class="relative block aspect-[4/3] overflow-hidden rounded-t-3xl bg-slate-100">
        @if ($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-slate-400">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
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
    
    <div class="flex flex-1 flex-col p-6">
        @if ($product->category)
            <a href="{{ route('catalog.categories.show', $product->category) }}" class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-500 hover:text-slate-900">
                {{ $product->category->name }}
            </a>
        @endif
        
        <h3 class="mb-2 text-lg font-bold text-slate-900">
            <a href="{{ route('catalog.products.show', $product) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        
        <div class="mt-auto pt-4">
            @include('frontend.themes.default.components.price', [
                'price' => $product->price,
                'salePrice' => $product->sale_price,
            ])
        </div>
    </div>
</div>
