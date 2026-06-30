@php
    $action = $action ?? '#';
    $label = $label ?? 'Delete';
    $message = $message ?? 'Are you sure you want to delete this item?';
    $buttonClass = $buttonClass ?? 'btn btn-danger';
@endphp

<form method="POST" action="{{ $action }}" class="d-inline" onsubmit="return confirm(@js($message))">
    @csrf
    @method('DELETE')
    <button type="submit" class="{{ $buttonClass }}">{{ $label }}</button>
</form>
