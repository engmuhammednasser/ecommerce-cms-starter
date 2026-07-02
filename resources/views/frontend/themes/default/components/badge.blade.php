@props([
    'type' => 'default', // default, success, danger, warning, info
    'text' => '',
])

@php
    $classes = [
        'default' => 'bg-slate-100 text-slate-800',
        'success' => 'bg-emerald-100 text-emerald-800',
        'danger'  => 'bg-rose-100 text-rose-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'info'    => 'bg-blue-100 text-blue-800',
    ];
    $activeClass = $classes[$type] ?? $classes['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold $activeClass"]) }}>
    {{ $text ?? $slot }}
</span>
