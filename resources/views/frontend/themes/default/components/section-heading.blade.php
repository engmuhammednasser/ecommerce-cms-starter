@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-8 text-center sm:text-left']) }}>
    <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h2>
    @if($subtitle)
        <p class="mt-2 text-slate-600">{{ $subtitle }}</p>
    @endif
</div>
