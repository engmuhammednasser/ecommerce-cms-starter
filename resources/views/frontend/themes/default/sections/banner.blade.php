@php
    /**
     * Banner image priority chain (TASK-055D):
     * 1. $section->backgroundImage (Media record from TASK-055A)
     * 2. $section->desktopImage
     * 3. $section->image (legacy)
     */
    $bgImgUrl = null;
    if ($section->relationLoaded('backgroundImage') && $section->backgroundImage) {
        $bgImgUrl = $section->backgroundImage->url();
    } elseif ($section->relationLoaded('desktopImage') && $section->desktopImage) {
        $bgImgUrl = $section->desktopImage->url();
    } elseif ($section->image) {
        $bgImgUrl = asset('storage/' . $section->image);
    }

    $imgAlt  = $section->image_alt ?: ($section->title ?? 'Banner');
    $overlay = $section->overlay_style ?? 'none';

    $overlayClass = match ($overlay) {
        'dark'     => 'bg-slate-900/50',
        'light'    => 'bg-white/30',
        'gradient' => 'bg-gradient-to-r from-slate-900/60 to-transparent',
        default    => '',
    };

    $hasBackground = (bool) $bgImgUrl;
@endphp

<section class="mx-auto max-w-6xl px-6 py-10">
    <div class="relative overflow-hidden rounded-3xl {{ $hasBackground ? '' : 'border border-slate-200 bg-white' }} shadow-sm">

        {{-- Background image --}}
        @if ($bgImgUrl)
            <img src="{{ $bgImgUrl }}" alt="{{ $imgAlt }}"
                 class="absolute inset-0 h-full w-full object-cover object-{{ $section->image_position ?? 'center' }}">
        @endif

        {{-- Overlay --}}
        @if ($overlayClass)
            <div class="absolute inset-0 {{ $overlayClass }}"></div>
        @endif

        {{-- Content --}}
        <div class="relative {{ $hasBackground ? 'lg:w-1/2' : '' }} space-y-4 p-8 lg:p-10 {{ $hasBackground ? 'text-white' : '' }}">
            @if ($section->subtitle)
                <p class="text-sm font-semibold uppercase tracking-wide {{ $hasBackground ? 'text-white/70' : 'text-slate-500' }}">{{ $section->subtitle }}</p>
            @endif

            @if ($section->title)
                <h2 class="text-3xl font-semibold tracking-tight {{ $hasBackground ? 'text-white' : 'text-slate-950' }}">{{ $section->title }}</h2>
            @endif

            @if ($section->content)
                <p class="leading-7 {{ $hasBackground ? 'text-white/80' : 'text-slate-600' }}">{{ $section->content }}</p>
            @endif

            @if ($section->button_text && $section->button_url)
                <a href="{{ $section->button_url }}"
                   class="inline-flex rounded-full px-5 py-2.5 text-sm font-semibold transition
                          {{ $hasBackground
                              ? 'bg-white text-slate-900 hover:bg-slate-100'
                              : 'border border-slate-950 text-slate-950 hover:bg-slate-950 hover:text-white' }}">
                    {{ $section->button_text }}
                </a>
            @endif
        </div>
    </div>
</section>
