@extends('admin.layouts.app')

@section('title', $customer->name)
@section('page_title', $customer->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Customers', 'url' => route('admin.customers.index')],
        ['label' => $customer->name, 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-4">
            @include('admin.components.card', [
                'title' => 'Customer Info',
                'slot' => view('admin.customers._details', ['customer' => $customer])->render(),
            ])

            @include('admin.components.card', [
                'title' => 'Checkout Address',
                'slot' => view('admin.customers._address', ['customer' => $customer])->render(),
            ])
        </div>

        <div class="col-lg-8">
            @include('admin.components.card', [
                'title' => 'Order History',
                'bodyClass' => 'p-0',
                'slot' => view('admin.customers._orders', ['customer' => $customer])->render(),
            ])
        </div>
    </div>
@endsection
