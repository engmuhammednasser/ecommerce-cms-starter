@if ($pages->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No pages created',
        'message' => 'Create the first editable CMS page for this store.',
        'actionLabel' => 'Create Page',
        'actionUrl' => route('admin.pages.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>
                            @include('admin.components.status-badge', ['status' => $page->status])
                        </td>
                        <td>{{ $page->updated_at?->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.pages.destroy', $page),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this page?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $pages->links() }}
    </div>
@endif
