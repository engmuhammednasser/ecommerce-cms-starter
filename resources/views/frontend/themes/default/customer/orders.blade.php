@extends('frontend.themes.default.layouts.app')

@section('title', $title ?? 'Order History')

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? 'Order History'])

    <div class="mx-auto max-w-6xl px-6 py-10">
        <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
            <aside>
                @include('frontend.themes.default.customer.partials.sidebar')
            </aside>

            <div>
                @if ($orders->isEmpty())
                    @include('frontend.themes.default.components.empty-state', [
                        'title' => 'No orders yet',
                        'message' => 'You haven\'t placed any orders yet.',
                        'actionText' => 'Start shopping',
                        'actionUrl' => route('catalog.shop'),
                    ])
                @else
                    <div class="space-y-6">
                        @foreach ($orders as $order)
                            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 bg-slate-50 p-6 sm:rounded-t-3xl">
                                    <div class="grid flex-1 grid-cols-2 gap-4 sm:grid-cols-4">
                                        <div>
                                            <div class="text-xs font-semibold uppercase text-slate-500">Order Placed</div>
                                            <div class="text-sm font-medium text-slate-900">{{ $order->created_at->format('M j, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-semibold uppercase text-slate-500">Total</div>
                                            <div class="text-sm font-medium text-slate-900">{{ number_format($order->total, 2) }} ج.م</div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-semibold uppercase text-slate-500">Status</div>
                                            <div class="text-sm font-medium text-slate-900">
                                                @include('frontend.themes.default.components.badge', [
                                                    'type' => $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning'),
                                                    'text' => ucfirst($order->status),
                                                ])
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-semibold uppercase text-slate-500">Order #</div>
                                            <div class="text-sm font-medium text-slate-900">{{ $order->order_number }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divide-y divide-slate-100 p-6">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-slate-900">{{ $item->product_name }}</h4>
                                                @if ($item->variant_label)
                                                    <div class="text-sm text-slate-500">{{ $item->variant_label }}</div>
                                                @endif
                                                <div class="text-sm text-slate-600">{{ $item->quantity }} x {{ number_format($item->unit_price, 2) }} ج.م</div>
                                            </div>
                                            <div class="font-semibold text-slate-900">{{ number_format($item->line_total, 2) }} ج.م</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
