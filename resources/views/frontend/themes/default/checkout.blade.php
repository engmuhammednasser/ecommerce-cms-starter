@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-10 lg:grid-cols-[1fr_22rem]">
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:p-8">
            @csrf

            <div>
                <label for="customer_name" class="mb-2 block text-sm font-medium text-slate-700">Full Name *</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $customer?->name) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                @error('customer_name')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="customer_email" class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $customer?->email) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                @error('customer_email')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="customer_phone" class="mb-2 block text-sm font-medium text-slate-700">Phone Number</label>
                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $customer?->phone) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                @error('customer_phone')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="customer_address" class="mb-2 block text-sm font-medium text-slate-700">Shipping Address *</label>
                <textarea id="customer_address" name="customer_address" rows="3" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">{{ old('customer_address', $defaultAddress?->address) }}</textarea>
                @error('customer_address')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="shipping_rate_id" class="mb-1 block text-sm font-medium text-slate-600">Shipping Method</label>
                <select id="shipping_rate_id" name="shipping_rate_id" required class="w-full rounded-xl border border-slate-300 px-3 py-3 bg-white">
                    <option value="">Select a shipping method</option>
                    @foreach ($shippingZones as $zone)
                        <optgroup label="{{ $zone->name }}">
                            @foreach ($zone->rates as $rate)
                                <option value="{{ $rate->id }}" data-rate="{{ $rate->rate }}" data-threshold="{{ $rate->free_shipping_threshold }}">
                                    {{ $rate->name }} - {{ number_format($rate->rate, 2) }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('shipping_rate_id')
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

            @if ($cashOnDeliveryEnabled || $dummyGatewayEnabled)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                    @if ($cashOnDeliveryEnabled)
                    <label class="flex items-center gap-3 text-sm">
                        <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                        <span>{{ setting('payment.cash_on_delivery_label', 'Cash on delivery') }}</span>
                    </label>
                    @endif

                    @if ($dummyGatewayEnabled)
                    <label class="flex items-center gap-3 text-sm">
                        <input type="radio" name="payment_method" value="dummy_gateway" {{ !$cashOnDeliveryEnabled ? 'checked' : '' }}>
                        <span>Credit Card (Dummy Gateway)</span>
                    </label>
                    @endif
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
                <span id="shipping-amount">{{ number_format($totals['shipping'], 2) }}</span>
            </div>
            <div class="mt-3 flex justify-between gap-4 text-sm">
                <span>{{ setting('tax.label', 'Tax') }}</span>
                <span id="tax-amount">{{ number_format($totals['tax'], 2) }}</span>
            </div>
            <div class="mt-4 flex justify-between gap-4 border-t border-slate-200 pt-4 text-lg font-semibold">
                <span>{{ setting('checkout.total_label', 'Total') }}</span>
                <span id="total-amount">{{ number_format($totals['total'], 2) }}</span>
            </div>
        </aside>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('shipping_rate_id');
            const shippingAmountEl = document.getElementById('shipping-amount');
            const taxAmountEl = document.getElementById('tax-amount');
            const totalAmountEl = document.getElementById('total-amount');

            const subtotal = {{ max(0, $cart['subtotal'] - $cart['discount']) }};
            const taxRate = {{ max(0, (float) setting('tax.percentage', 0)) }};

            function format(num) {
                return parseFloat(num).toFixed(2);
            }

            select.addEventListener('change', function() {
                const option = select.options[select.selectedIndex];
                if (!option || !option.value) {
                    return;
                }

                const rate = parseFloat(option.getAttribute('data-rate'));
                const threshold = option.getAttribute('data-threshold');
                
                let shipping = rate;
                if (threshold !== null && threshold !== '') {
                    if (subtotal >= parseFloat(threshold)) {
                        shipping = 0;
                    }
                }

                const tax = subtotal * (taxRate / 100);
                const total = subtotal + shipping + tax;

                shippingAmountEl.textContent = format(shipping);
                taxAmountEl.textContent = format(tax);
                totalAmountEl.textContent = format(total);
            });
            
            // Trigger change if a value is already selected (e.g. from old input)
            if (select.value) {
                select.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
