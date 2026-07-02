@if ($templates->count())
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Key</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($templates as $template)
                    <tr>
                        <td>{{ $template->name }}</td>
                        <td><code>{{ $template->key }}</code></td>
                        <td>{{ ucfirst($template->type) }}</td>
                        <td>
                            @include('admin.components.status-badge', [
                                'status' => $template->is_active ? 'active' : 'inactive',
                            ])
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.email-templates.show', $template) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.email-templates.edit', $template) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $templates->links() }}
    </div>
@else
    @include('admin.components.empty-state', [
        'title' => 'No email templates found',
        'message' => 'Run the email template seeder to create starter notification templates.',
    ])
@endif
