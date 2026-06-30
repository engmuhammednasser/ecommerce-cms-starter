@if ($activityLogs->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No activity logged yet',
        'message' => 'Admin actions will appear here after updates are made.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Actor</th>
                    <th>Action</th>
                    <th>Subject</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activityLogs as $activityLog)
                    <tr>
                        <td class="text-nowrap">{{ $activityLog->created_at?->format('Y-m-d H:i') }}</td>
                        <td>{{ $activityLog->actor_name ?: $activityLog->user?->name ?: 'System' }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($activityLog->action)) }}</td>
                        <td>
                            <div>{{ $activityLog->subject_name ?: 'General' }}</div>
                            @if ($activityLog->subject_type)
                                <div class="text-muted small">{{ class_basename($activityLog->subject_type) }} #{{ $activityLog->subject_id }}</div>
                            @endif
                        </td>
                        <td>
                            @if ($activityLog->properties)
                                <dl class="row mb-0 small">
                                    @foreach ($activityLog->properties as $key => $value)
                                        <dt class="col-sm-5">{{ str_replace('_', ' ', ucfirst($key)) }}</dt>
                                        <dd class="col-sm-7 mb-1">
                                            @if (is_array($value))
                                                {{ implode(' -> ', array_filter($value, fn ($item) => filled($item))) ?: 'None' }}
                                            @else
                                                {{ filled($value) ? $value : 'None' }}
                                            @endif
                                        </dd>
                                    @endforeach
                                </dl>
                            @else
                                <span class="text-muted">No extra details</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $activityLogs->links() }}
    </div>
@endif
