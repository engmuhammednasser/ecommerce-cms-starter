@php
    $mediaPickerItems = \App\Models\Media::query()
        ->where('type', 'image')
        ->latest()
        ->limit(60)
        ->get();
@endphp

<div class="modal fade" id="adminMediaPickerModal" tabindex="-1" aria-labelledby="adminMediaPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title fs-5" id="adminMediaPickerModalLabel">Choose Media</h2>
                    <p class="text-muted small mb-0">Select an existing media library image.</p>
                </div>
                <button type="button" class="btn-close" data-media-picker-close aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($mediaPickerItems->isEmpty())
                    @include('admin.components.empty-state', [
                        'title' => 'No image media available',
                        'message' => 'Upload image files in the Media Library before using the picker.',
                    ])
                @else
                    <div class="row g-3">
                        @foreach ($mediaPickerItems as $media)
                            <div class="col-6 col-md-4 col-lg-3">
                                <button
                                    type="button"
                                    class="btn btn-light border w-100 h-100 p-2 text-start"
                                    data-media-picker-select
                                    data-media-path="{{ $media->path }}"
                                    data-media-url="{{ $media->url() }}"
                                >
                                    <img src="{{ $media->url() }}" alt="{{ $media->alt_text ?: $media->original_name }}" class="img-fluid rounded mb-2" style="aspect-ratio: 1 / 1; object-fit: cover;">
                                    <span class="d-block small fw-semibold text-truncate">{{ $media->original_name }}</span>
                                    <span class="d-block small text-muted text-truncate">{{ $media->path }}</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">Open Media Library</a>
                <button type="button" class="btn btn-secondary" data-media-picker-close>Close</button>
            </div>
        </div>
    </div>
</div>
