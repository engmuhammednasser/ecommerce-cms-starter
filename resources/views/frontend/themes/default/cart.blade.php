@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto max-w-6xl px-6 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($cart['items']->isEmpty())
            <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-600 shadow-sm">
                {{ setting('cart.empty_message', 'Your cart is empty.') }}
            </div>
        @else
            <div class="grid gap-8 lg:grid-cols-[1fr_20rem]">
                <div class="space-y-4">
                    @foreach ($cart['items'] as $line)
                        @php
                            $product = $line['product'];
                            $image = $product->primaryImage?->path;
                        @endphp

                        <div class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-[7rem_1fr_auto]">
                            <div class="aspect-square overflow-hidden rounded-xl bg-slate-100">
                                @if ($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->primaryImage?->alt_text ?: $product->name }}" class="h-full w-full object-cover">
                                @endif
                            </div>

                            <div class="space-y-2">
                                <h2 class="font-semibold">
                                    <a href="{{ route('catalog.products.show', $product) }}" class="hover:text-slate-700">
                                        {{ $product->name }}
                                    </a>
                                </h2>
                                <div class="text-sm text-slate-600">{{ number_format($line['unit_price'], 2) }}</div>

                                <form method="POST" action="{{ route('cart.items.update', $product) }}" class="flex max-w-xs items-end gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-sm">
                                        <span class="mb-1 block text-slate-600">{{ setting('cart.quantity_label', 'Quantity') }}</span>
                                        <input type="number" name="quantity" value="{{ $line['quantity'] }}" min="1" class="w-24 rounded-xl border border-slate-300 px-3 py-2">
                                    </label>
                                    <button type="submit" class="rounded-full border border-slate-950 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-950 hover:text-white">
                                        {{ setting('cart.update_label', 'Update') }}
                                    </button>
                                </form>
                            </div>

                            <div class="flex flex-col items-start justify-between gap-4 sm:items-end">
                                <div class="font-semibold">{{ number_format($line['line_total'], 2) }}</div>
                                <form method="POST" action="{{ route('cart.items.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-slate-500 underline hover:text-slate-950">
                                        {{ setting('cart.remove_label', 'Remove') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">{{ setting('cart.summary_title', 'Cart summary') }}</h2>
                    <dl class="mt-6 space-y-3 text-sm">
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-600">{{ setting('cart.items_label', 'Items') }}</dt>
                            <dd>{{ $cart['item_count'] }}</dd>
                        </div>
                        <div class="flex justify-between gap-4 border-t border-slate-200 pt-3">
                            <dt class="font-semibold">{{ setting('cart.subtotal_label', 'Subtotal') }}</dt>
                            <dd class="font-semibold">{{ number_format($cart['subtotal'], 2) }}</dd>
                        </div>
                        @if ($cart['coupon'])
                            <div class="flex justify-between gap-4 text-emerald-700">
                                <dt>Coupon {{ $cart['coupon']['code'] }}</dt>
                                <dd>-{{ number_format($cart['discount'], 2) }}</dd>
                            </div>
                        @endif
                    </dl>
                    <div class="mt-6 border-t border-slate-200 pt-4">
                        @if ($cart['coupon'])
                            <form method="POST" action="{{ route('cart.coupon.remove') }}" class="flex items-center justify-between gap-3 rounded-2xl bg-emerald-50 p-3 text-sm text-emerald-800">
                                @csrf
                                @method('DELETE')
                                <span>{{ $cart['coupon']['code'] }} applied</span>
                                <button type="submit" class="font-semibold underline">Remove</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('cart.coupon.apply') }}" class="space-y-3">
                                @csrf
                                <label for="coupon_code" class="block text-sm font-medium text-slate-600">Coupon code</label>
                                <div class="flex gap-2">
                                    <input id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}" class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3 py-2 text-sm">
                                    <button type="submit" class="rounded-full border border-slate-950 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-950 hover:text-white">
                                        Apply
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <a href="{{ route('checkout.create') }}" class="mt-6 block rounded-full bg-slate-950 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-700">
                        {{ setting('checkout.button_label', 'Checkout') }}
                    </a>
                </aside>
            </div>
        @endif
    </div>
@endsection
