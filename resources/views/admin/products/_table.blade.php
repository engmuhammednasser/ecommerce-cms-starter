@if ($products->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No products created',
        'message' => 'Create the first catalog product for this store.',
        'actionLabel' => 'Create Product',
        'actionUrl' => route('admin.products.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku ?: 'Not set' }}</td>
                        <td>{{ $product->category?->name ?: 'None' }}</td>
                        <td>{{ $product->brand?->name ?: 'None' }}</td>
                        <td>{{ number_format((float) $product->price, 2) }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>
                            @include('admin.components.status-badge', ['status' => $product->status])
                        </td>
                        <td>{{ $product->featured ? 'Yes' : 'No' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.products.destroy', $product),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this product?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $products->links() }}
    </div>
@endif
