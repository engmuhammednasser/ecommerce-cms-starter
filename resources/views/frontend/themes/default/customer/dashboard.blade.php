@extends('frontend.themes.default.layouts.app')

@section('title', $title ?? 'My Account')

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? 'My Account'])

    <div class="mx-auto max-w-6xl px-6 py-10">
        <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
            <aside>
                @include('frontend.themes.default.customer.partials.sidebar')
            </aside>

            <div class="space-y-8">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h2 class="mb-2 text-xl font-bold text-slate-900">Welcome, {{ $customer->name }}!</h2>
                    <p class="text-slate-600">From your account dashboard you can view your recent orders and manage your saved addresses.</p>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-bold text-slate-900">Recent Orders</h3>
                    @if ($recentOrders->isEmpty())
                        @include('frontend.themes.default.components.empty-state', [
                            'title' => 'No orders yet',
                            'message' => 'You haven\'t placed any orders yet.',
                            'actionText' => 'Start shopping',
                            'actionUrl' => route('catalog.shop'),
                        ])
                    @else
                        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="border-b border-slate-200 bg-slate-50 text-slate-900">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Order</th>
                                        <th class="px-6 py-4 font-semibold">Date</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-slate-900">#{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">{{ $order->created_at->format('M j, Y') }}</td>
                                            <td class="px-6 py-4">
                                                @include('frontend.themes.default.components.badge', [
                                                    'type' => $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning'),
                                                    'text' => ucfirst($order->status),
                                                ])
                                            </td>
                                            <td class="px-6 py-4 font-medium text-slate-900">{{ number_format($order->total, 2) }} ج.م</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('customer.orders') }}" class="text-sm font-semibold text-slate-900 hover:underline">View all orders &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
