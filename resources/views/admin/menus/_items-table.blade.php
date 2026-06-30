@php
    $items = $menu->items;
@endphp

@if ($items->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No menu items',
        'message' => 'Add page, category, product, or custom URL links to this menu.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Label</th>
                    <th>Type</th>
                    <th>Parent</th>
                    <th>Target</th>
                    <th>State</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>{{ $item->label }}</td>
                        <td>{{ $item->typeLabel() }}</td>
                        <td>{{ $item->parent?->label ?: 'None' }}</td>
                        <td>{{ $item->url ?: ($item->reference_id ? 'Reference #' . $item->reference_id : 'Not set') }}</td>
                        <td>
                            @include('admin.components.status-badge', [
                                'status' => $item->is_active ? 'active' : 'inactive',
                            ])
                        </td>
                        <td class="text-end">
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.menus.items.destroy', [$menu, $item]),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this menu item?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
