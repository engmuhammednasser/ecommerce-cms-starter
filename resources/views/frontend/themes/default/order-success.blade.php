@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto max-w-6xl px-6 py-10">
        <div class="rounded-3xl border border-emerald-200 bg-white p-6 shadow-sm lg:p-8">
            <p class="text-lg font-medium text-emerald-800">{{ setting('checkout.success_message', 'Your order has been received.') }}</p>

            <dl class="mt-6 grid gap-3 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('checkout.order_number_label', 'Order number') }}</dt>
                    <dd>{{ $order->order_number }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('checkout.order_total_label', 'Total') }}</dt>
                    <dd>{{ number_format((float) $order->total, 2) }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('shipping.label', 'Shipping') }}</dt>
                    <dd>{{ number_format((float) $order->shipping_amount, 2) }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('tax.label', 'Tax') }}</dt>
                    <dd>{{ number_format((float) $order->tax_amount, 2) }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('payment.method_label', 'Payment method') }}</dt>
                    <dd>{{ $order->payment_method === 'cash_on_delivery' ? setting('payment.cash_on_delivery_label', 'Cash on delivery') : 'Not set' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">{{ setting('checkout.order_status_label', 'Status') }}</dt>
                    <dd>{{ ucfirst($order->status) }}</dd>
                </div>
            </dl>
        </div>

        <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:p-8">
            <h2 class="text-lg font-semibold text-slate-950">{{ setting('checkout.order_items_title', 'Order items') }}</h2>
            <div class="mt-4 space-y-3">
                @foreach ($order->items as $item)
                    <div class="flex justify-between gap-4 text-sm">
                        <div>
                            <div>{{ $item->product_name }}</div>
                            <div class="text-slate-500">{{ $item->quantity }} x {{ number_format((float) $item->unit_price, 2) }}</div>
                        </div>
                        <div>{{ number_format((float) $item->line_total, 2) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
