@php
    $title = $title ?? 'Nothing here yet';
    $message = $message ?? 'Records will appear here once they are created.';
    $actionLabel = $actionLabel ?? null;
    $actionUrl = $actionUrl ?? '#';
@endphp

<div class="text-center text-muted py-5">
    <h3 class="h5 text-body mb-2">{{ $title }}</h3>
    <p class="mb-3">{{ $message }}</p>

    @if ($actionLabel)
        <a href="{{ $actionUrl }}" class="btn btn-primary">{{ $actionLabel }}</a>
    @endif
</div>
