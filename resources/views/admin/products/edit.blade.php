@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Product',
        'slot' => view('admin.products._form', [
            'product' => $product,
            'categoryOptions' => $categoryOptions,
            'brandOptions' => $brandOptions,
            'imagePaths' => $imagePaths,
            'action' => route('admin.products.update', $product),
            'method' => 'PUT',
        ])->render(),
    ])

    {{-- Variants Panel --}}
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Product Variants</h3>
            <a href="{{ route('admin.products.variants.create', $product) }}" class="btn btn-primary btn-sm">Add Variant</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Attributes</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($product->variants as $variant)
                        <tr>
                            <td>{{ $variant->attributeValues->map(fn($av) => $av->attribute?->name . ': ' . $av->value)->implode(', ') ?: '—' }}</td>
                            <td><code>{{ $variant->sku ?: '—' }}</code></td>
                            <td>{{ $variant->price !== null ? number_format($variant->price, 2) : '—' }}</td>
                            <td>{{ $variant->sale_price !== null ? number_format($variant->sale_price, 2) : '—' }}</td>
                            <td>
                                @if ($variant->stock_quantity <= 0)
                                    <span class="badge text-bg-danger">0</span>
                                @else
                                    <span class="badge text-bg-success">{{ $variant->stock_quantity }}</span>
                                @endif
                            </td>
                            <td>@include('admin.components.status-badge', ['status' => $variant->status])</td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}" class="btn btn-sm btn-primary">Edit</a>
                                @include('admin.components.confirm-delete', [
                                    'action' => route('admin.products.variants.destroy', [$product, $variant]),
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-muted">No variants yet. <a href="{{ route('admin.products.variants.create', $product) }}">Add the first one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
