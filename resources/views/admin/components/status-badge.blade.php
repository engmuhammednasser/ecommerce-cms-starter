@php
    $status = $status ?? 'inactive';
    $label = $label ?? ucfirst(str_replace(['_', '-'], ' ', $status));
    $type = $type ?? match ($status) {
        'active', 'published', 'completed', 'paid' => 'success',
        'pending', 'draft', 'processing' => 'warning',
        'cancelled', 'failed', 'inactive' => 'secondary',
        'refunded', 'error' => 'danger',
        default => 'info',
    };
@endphp

<span class="badge text-bg-{{ $type }}">{{ $label }}</span>
