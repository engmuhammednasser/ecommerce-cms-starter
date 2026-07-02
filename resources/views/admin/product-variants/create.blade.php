@extends('admin.layouts.app')

@section('title', 'Add Variant — ' . $product->name)
@section('page_title', 'Add Variant')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product->name, 'url' => route('admin.products.edit', $product)],
        ['label' => 'Add Variant', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Variant to {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST">
                @csrf
                @include('admin.product-variants._form', ['variant' => null])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Variant</button>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
