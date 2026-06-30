@if ($sections->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No homepage sections',
        'message' => 'Create sections such as hero, banners, FAQ, or calls to action.',
        'actionLabel' => 'Create Section',
        'actionUrl' => route('admin.sections.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Related Page</th>
                    <th>State</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr>
                        <td>{{ $section->sort_order }}</td>
                        <td>{{ $section->title ?: 'Untitled section' }}</td>
                        <td>{{ $section->typeLabel() }}</td>
                        <td>{{ $section->page?->title ?: 'Homepage / global' }}</td>
                        <td>
                            @include('admin.components.status-badge', [
                                'status' => $section->is_active ? 'active' : 'inactive',
                            ])
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.sections.show', $section) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.sections.destroy', $section),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this homepage section?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $sections->links() }}
    </div>
@endif
