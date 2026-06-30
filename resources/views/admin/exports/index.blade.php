@extends('admin.layouts.app')

@section('title', 'Exports')
@section('page_title', 'Exports')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Exports', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row g-3">
        <div class="col-md-4">
            @include('admin.components.card', [
                'title' => 'Products CSV',
                'subtitle' => $productsCount . ' records available',
                'slot' => $productsCount > 0
                    ? '<p class="text-muted">Download product catalog data using existing product and category fields.</p><a href="' . route('admin.exports.products') . '" class="btn btn-primary">Download Products</a>'
                    : view('admin.components.empty-state', ['title' => 'No products to export', 'message' => 'Products will be available for export after they are created.'])->render(),
            ])
        </div>

        <div class="col-md-4">
            @include('admin.components.card', [
                'title' => 'Orders CSV',
                'subtitle' => $ordersCount . ' records available',
                'slot' => $ordersCount > 0
                    ? '<p class="text-muted">Download order summaries, customer checkout details, and totals.</p><a href="' . route('admin.exports.orders') . '" class="btn btn-primary">Download Orders</a>'
                    : view('admin.components.empty-state', ['title' => 'No orders to export', 'message' => 'Orders will be available for export after checkout creates them.'])->render(),
            ])
        </div>

        <div class="col-md-4">
            @include('admin.components.card', [
                'title' => 'Customers CSV',
                'subtitle' => $customersCount . ' records available',
                'slot' => $customersCount > 0
                    ? '<p class="text-muted">Download customer records created by checkout and demo seed data.</p><a href="' . route('admin.exports.customers') . '" class="btn btn-primary">Download Customers</a>'
                    : view('admin.components.empty-state', ['title' => 'No customers to export', 'message' => 'Customers will be available for export after checkout creates them.'])->render(),
            ])
        </div>
    </div>
@endsection
