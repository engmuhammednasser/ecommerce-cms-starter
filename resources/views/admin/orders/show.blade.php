@extends('admin.layouts.app')

@section('title', $order->order_number)
@section('page_title', $order->order_number)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Orders', 'url' => route('admin.orders.index')],
        ['label' => $order->order_number, 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.card', [
                'title' => 'Order Items',
                'bodyClass' => 'p-0',
                'slot' => view('admin.orders._items', ['order' => $order])->render(),
            ])

            @include('admin.components.card', [
                'title' => 'Customer & Shipping Info',
                'slot' => view('admin.orders._customer', ['order' => $order])->render(),
            ])

            @include('admin.components.card', [
                'title' => 'Status Timeline',
                'slot' => view('admin.orders._timeline', ['order' => $order])->render(),
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.card', [
                'title' => 'Order Status',
                'slot' => view('admin.orders._status-form', ['order' => $order])->render(),
            ])

            @include('admin.components.card', [
                'title' => 'Payment Summary',
                'slot' => view('admin.orders._summary', ['order' => $order])->render(),
            ])

            @include('admin.components.card', [
                'title' => 'Notes',
                'slot' => view('admin.orders._notes', ['order' => $order])->render(),
            ])
        </div>
    </div>
@endsection
