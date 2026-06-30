@if ($mediaItems->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No media uploaded',
        'message' => 'Uploaded media files will appear here for reuse across the admin.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 90px;">Preview</th>
                    <th>File</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mediaItems as $media)
                    <tr>
                        <td>
                            @if ($media->isImage())
                                <img src="{{ $media->url() }}" alt="{{ $media->alt_text ?: $media->original_name }}" class="img-thumbnail" style="width: 64px; height: 64px; object-fit: cover;">
                            @else
                                <span class="badge text-bg-secondary">File</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $media->original_name }}</div>
                            <div class="text-muted small">{{ $media->path }}</div>
                        </td>
                        <td>{{ ucfirst($media->type) }}</td>
                        <td>{{ number_format($media->size / 1024, 1) }} KB</td>
                        <td>{{ $media->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ $media->url() }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Open</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.media.destroy', $media),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this media file?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $mediaItems->links() }}
    </div>
@endif
