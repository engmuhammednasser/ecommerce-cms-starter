@php
    $items = collect($items ?? []);
@endphp

@if ($items->isNotEmpty())
    <nav aria-label="{{ $label ?? 'Primary navigation' }}">
        <ul class="flex flex-wrap items-center gap-3 text-sm">
            @foreach ($items as $item)
                @continue(isset($item->is_active) && ! $item->is_active)
                <li>
                    <a href="{{ $item->url ?? '#' }}" class="rounded-full px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">
                        {{ $item->label }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
