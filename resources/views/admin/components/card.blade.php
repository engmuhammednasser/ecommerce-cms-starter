@php
    $title = $title ?? null;
    $subtitle = $subtitle ?? null;
    $class = $class ?? '';
    $bodyClass = $bodyClass ?? '';
    $footer = $footer ?? null;
@endphp

<div class="card {{ $class }}">
    @if ($title || $subtitle || isset($actions))
        <div class="card-header">
            <div class="d-flex align-items-start justify-content-between gap-3">
                <div>
                    @if ($title)
                        <h3 class="card-title mb-0">{{ $title }}</h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-muted mb-0 small">{{ $subtitle }}</p>
                    @endif
                </div>
                @isset($actions)
                    <div>{!! $actions !!}</div>
                @endisset
            </div>
        </div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        {!! $slot ?? '' !!}
    </div>

    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
