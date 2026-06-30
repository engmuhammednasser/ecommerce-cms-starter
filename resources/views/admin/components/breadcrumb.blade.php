@php
    $items = $items ?? [['label' => 'Dashboard', 'url' => '#']];
@endphp

<ol class="breadcrumb {{ $class ?? '' }}">
    @foreach ($items as $item)
        @if ($loop->last)
            <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
            </li>
        @endif
    @endforeach
</ol>
