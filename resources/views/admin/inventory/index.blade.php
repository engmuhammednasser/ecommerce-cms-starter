@extends('layouts.admin')

@section('title', 'Inventory')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $lowStockCount }}</h3>
                    <p>Low Stock (≤ {{ $lowStockThreshold }})</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $outOfStockCount }}</h3>
                    <p>Out of Stock</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Inventory</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                <a href="{{ route('admin.inventory.index', ['filter' => 'low_stock']) }}" class="btn btn-sm {{ request('filter') === 'low_stock' ? 'btn-warning' : 'btn-outline-secondary' }}">Low Stock</a>
                <a href="{{ route('admin.inventory.index', ['filter' => 'out_of_stock']) }}" class="btn btn-sm {{ request('filter') === 'out_of_stock' ? 'btn-danger' : 'btn-outline-secondary' }}">Out of Stock</a>
            </div>
        </div>
        <div class="card-body p-0">
            <form method="GET" action="{{ route('admin.inventory.index') }}" class="p-3">
                @if (request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by product name or SKU..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px">Image</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th style="width: 140px">Stock</th>
                        <th style="width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="" class="img-thumbnail" style="width:40px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}">{{ $product->name }}</a>
                            </td>
                            <td><code>{{ $product->sku ?? '—' }}</code></td>
                            <td>{{ $product->category?->name ?? '—' }}</td>
                            <td>@include('admin.components.status-badge', ['status' => $product->status])</td>
                            <td>
                                @if ($product->stock_quantity <= 0)
                                    <span class="badge text-bg-danger">Out of stock</span>
                                @elseif ($product->stock_quantity <= $lowStockThreshold)
                                    <span class="badge text-bg-warning">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="badge text-bg-success">{{ $product->stock_quantity }}</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.inventory.update', $product) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" min="0" class="form-control form-control-sm" style="width: 70px">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
