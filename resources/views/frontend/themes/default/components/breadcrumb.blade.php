@props([
    'items' => [] // array of ['label' => '...', 'url' => '...']
])

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'mb-6']) }}>
    <ol class="flex items-center space-x-2 text-sm text-slate-500">
        <li>
            <a href="{{ url('/') }}" class="hover:text-slate-900 transition">Home</a>
        </li>
        @foreach($items as $item)
            <li>
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-slate-900 transition">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-slate-900">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
