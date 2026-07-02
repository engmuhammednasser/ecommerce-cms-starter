@props([
    'title',
    'message'     => null,
    'actionText'  => null,
    'actionUrl'   => null,
    'compact'     => false,
])

@if ($compact)
    {{-- Compact inline variant for use inside sections --}}
    <p class="py-2 text-sm text-slate-400">{{ $message ?: $title }}</p>
@else
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm']) }}>
        <h3 class="text-base font-semibold text-slate-700">{{ $title }}</h3>
        @if ($message)
            <p class="mt-1.5 text-sm text-slate-400">{{ $message }}</p>
        @endif
        @if ($actionText && $actionUrl)
            <div class="mt-4">
                <a href="{{ $actionUrl }}"
                   class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    {{ $actionText }}
                </a>
            </div>
        @endif
    </div>
@endif
