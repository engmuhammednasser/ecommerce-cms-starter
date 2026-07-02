@props([
    'price',
    'salePrice' => null,
    'size' => 'md', // sm, md, lg
])

@php
    $sizeClasses = [
        'sm' => 'text-sm',
        'md' => 'text-lg',
        'lg' => 'text-2xl',
    ];
    $textSize = $sizeClasses[$size] ?? $sizeClasses['md'];
    $currency = setting('store.currency_symbol', 'ج.م');
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-2"]) }}>
    @if($salePrice > 0)
        <span class="{{ $textSize }} font-bold text-slate-900">{{ number_format($salePrice, 2) }} {{ $currency }}</span>
        <span class="text-sm font-medium text-slate-400 line-through">{{ number_format($price, 2) }} {{ $currency }}</span>
    @else
        <span class="{{ $textSize }} font-bold text-slate-900">{{ number_format($price, 2) }} {{ $currency }}</span>
    @endif
</div>
