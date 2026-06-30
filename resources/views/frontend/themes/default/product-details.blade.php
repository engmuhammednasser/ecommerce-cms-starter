@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <article class="mx-auto grid max-w-6xl gap-10 px-6 py-10 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="space-y-4">
            @forelse ($product->images as $image)
                <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-sm">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text ?: $product->name }}" class="h-full w-full object-cover">
                </div>
            @empty
                <div class="flex aspect-[4/3] items-center justify-center rounded-3xl border border-slate-200 bg-white text-slate-500 shadow-sm">
                    {{ setting('catalog.no_product_image_label', 'No image available') }}
                </div>
            @endforelse
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:p-8">
            @if ($product->category)
                <a href="{{ route('catalog.categories.show', $product->category) }}" class="text-sm font-semibold uppercase tracking-wide text-slate-500 hover:text-slate-900">
                    {{ $product->category->name }}
                </a>
            @endif

            <div class="mt-5">
                @if ($product->sale_price)
                    <div class="flex items-center gap-3">
                        <span class="text-3xl font-semibold text-slate-950">{{ number_format((float) $product->sale_price, 2) }}</span>
                        <span class="text-slate-400 line-through">{{ number_format((float) $product->price, 2) }}</span>
                    </div>
                @else
                    <div class="text-3xl font-semibold text-slate-950">{{ number_format((float) $product->price, 2) }}</div>
                @endif
            </div>

            <form method="POST" action="{{ route('cart.items.store', $product) }}" class="mt-6 flex flex-wrap items-end gap-3">
                @csrf
                <label class="block text-sm">
                    <span class="mb-1 block text-slate-600">{{ setting('cart.quantity_label', 'Quantity') }}</span>
                    <input type="number" name="quantity" value="1" min="1" class="w-24 rounded-xl border border-slate-300 px-3 py-3">
                </label>
                <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                    {{ setting('cart.add_label', 'Add to cart') }}
                </button>
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
                        <dd>{{ $product->sku }}</dd>
                    </div>
                @endif
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('catalog.stock_label', 'Stock') }}</dt>
                    <dd>{{ $product->stock_quantity }}</dd>
                </div>
            </dl>
        </div>
    </article>
@endsection
