@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-10 lg:grid-cols-[1fr_22rem]">
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:p-8">
            @csrf

            <div>
                <label for="customer_name" class="mb-1 block text-sm font-medium text-slate-600">{{ setting('checkout.name_label', 'Name') }}</label>
                <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-3">
                @error('customer_name')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="customer_email" class="mb-1 block text-sm font-medium text-slate-600">{{ setting('checkout.email_label', 'Email') }}</label>
                    <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email') }}" class="w-full rounded-xl border border-slate-300 px-3 py-3">
                    @error('customer_email')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="customer_phone" class="mb-1 block text-sm font-medium text-slate-600">{{ setting('checkout.phone_label', 'Phone') }}</label>
                    <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" class="w-full rounded-xl border border-slate-300 px-3 py-3">
                    @error('customer_phone')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="customer_address" class="mb-1 block text-sm font-medium text-slate-600">{{ setting('checkout.address_label', 'Address') }}</label>
                <textarea id="customer_address" name="customer_address" rows="4" required class="w-full rounded-xl border border-slate-300 px-3 py-3">{{ old('customer_address') }}</textarea>
                @error('customer_address')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="notes" class="mb-1 block text-sm font-medium text-slate-600">{{ setting('checkout.notes_label', 'Notes') }}</label>
                <textarea id="notes" name="notes" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            @if ($cashOnDeliveryEnabled)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <label class="flex items-center gap-3 text-sm">
                        <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                        <span>{{ setting('payment.cash_on_delivery_label', 'Cash on delivery') }}</span>
                    </label>
                </div>

                <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                    {{ setting('checkout.place_order_label', 'Place order') }}
                </button>
            @else
                <div class="rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-600">
                    {{ setting('payment.no_methods_message', 'No payment method is currently available.') }}
                </div>
            @endif
        </form>

        <aside class="h-fit rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-950">{{ setting('cart.summary_title', 'Cart summary') }}</h2>
            <div class="mt-6 space-y-4">
                @foreach ($cart['items'] as $line)
                    <div class="flex justify-between gap-4 text-sm">
                        <div>
                            <div>{{ $line['product']->name }}</div>
                            <div class="text-slate-500">{{ $line['quantity'] }} x {{ number_format($line['unit_price'], 2) }}</div>
                        </div>
                        <div>{{ number_format($line['line_total'], 2) }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-between gap-4 border-t border-slate-200 pt-4 font-semibold">
                <span>{{ setting('cart.subtotal_label', 'Subtotal') }}</span>
                <span>{{ number_format($cart['subtotal'], 2) }}</span>
            </div>
            @if ($cart['coupon'])
                <div class="mt-3 flex justify-between gap-4 text-sm text-emerald-700">
                    <span>Coupon {{ $cart['coupon']['code'] }}</span>
                    <span>-{{ number_format($cart['discount'], 2) }}</span>
                </div>
            @endif
            <div class="mt-3 flex justify-between gap-4 text-sm">
                <span>{{ setting('shipping.label', 'Shipping') }}</span>
                <span>{{ number_format($totals['shipping'], 2) }}</span>
            </div>
            <div class="mt-3 flex justify-between gap-4 text-sm">
                <span>{{ setting('tax.label', 'Tax') }}</span>
                <span>{{ number_format($totals['tax'], 2) }}</span>
            </div>
            <div class="mt-4 flex justify-between gap-4 border-t border-slate-200 pt-4 text-lg font-semibold">
                <span>{{ setting('checkout.total_label', 'Total') }}</span>
                <span>{{ number_format($totals['total'], 2) }}</span>
            </div>
        </aside>
    </div>
@endsection
