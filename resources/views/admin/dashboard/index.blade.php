@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['products']) }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="small-box-icon">
                    <span aria-hidden="true">#</span>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">View products</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['orders']) }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="small-box-icon">
                    <span aria-hidden="true">#</span>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">View orders</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['customers']) }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="small-box-icon">
                    <span aria-hidden="true">#</span>
                </div>
                <a href="{{ route('admin.customers.index') }}" class="small-box-footer">View customers</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['pages']) }}</h3>
                    <p>Total Pages</p>
                </div>
                <div class="small-box-icon">
                    <span aria-hidden="true">#</span>
                </div>
                <a href="{{ route('admin.pages.index') }}" class="small-box-footer">View pages</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            @include('admin.components.card', [
                'title' => 'Total Sales',
                'slot' => '<div class="h3 mb-0">' . number_format($sales['total'], 2) . '</div><p class="text-muted mb-0 small">All order totals</p>',
            ])
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            @include('admin.components.card', [
                'title' => 'Completed Sales',
                'slot' => '<div class="h3 mb-0">' . number_format($sales['completed'], 2) . '</div><p class="text-muted mb-0 small">Completed order totals</p>',
            ])
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            @include('admin.components.card', [
                'title' => 'Pending Sales',
                'slot' => '<div class="h3 mb-0">' . number_format($sales['pending'], 2) . '</div><p class="text-muted mb-0 small">Pending order totals</p>',
            ])
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            @include('admin.components.card', [
                'title' => 'Average Order',
                'slot' => '<div class="h3 mb-0">' . number_format($sales['average_order'], 2) . '</div><p class="text-muted mb-0 small">Across all orders</p>',
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <div class="card-body p-0">
                    @if ($recentOrders->isEmpty())
                        @include('admin.components.empty-state', [
                            'title' => 'No recent orders',
                            'message' => 'Orders will appear here after customers complete checkout.',
                        ])
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a>
                                                <div class="text-muted small">{{ $order->created_at?->format('Y-m-d H:i') }}</div>
                                            </td>
                                            <td>
                                                <div>{{ $order->customer_name }}</div>
                                                <div class="text-muted small">{{ $order->customer_email ?: $order->customer_phone }}</div>
                                            </td>
                                            <td>@include('admin.components.status-badge', ['status' => $order->status])</td>
                                            <td class="text-end">{{ number_format((float) $order->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Links</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary">Add Product</a>
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-outline-primary">Create Page</a>
                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-primary">Upload Media</a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary">Store Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Products</h3>
                </div>
                <div class="card-body p-0">
                    @if ($recentProducts->isEmpty())
                        @include('admin.components.empty-state', [
                            'title' => 'No recent products',
                            'message' => 'Products will appear here after they are created.',
                        ])
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>SKU</th>
                                        <th>Status</th>
                                        <th class="text-end">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentProducts as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a>
                                                <div class="text-muted small">{{ $product->created_at?->format('Y-m-d H:i') }}</div>
                                            </td>
                                            <td>{{ $product->category?->name ?: 'None' }}</td>
                                            <td>{{ $product->sku ?: 'Not set' }}</td>
                                            <td>@include('admin.components.status-badge', ['status' => $product->status])</td>
                                            <td class="text-end">{{ number_format((int) $product->stock_quantity) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
