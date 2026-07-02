@php
    /**
     * Hero image priority chain (TASK-055D):
     * 1. $section->desktopImage  (Media record from TASK-055A)
     * 2. $section->image          (legacy string path)
     * 3. store.default_hero_image setting
     * 4. No image — text-only layout
     *
     * overlay_style: dark | light | gradient | none
     */
    $heroImgUrl = null;
    if ($section->relationLoaded('desktopImage') && $section->desktopImage) {
        $heroImgUrl = $section->desktopImage->url();
    } elseif ($section->relationLoaded('mobileImage') && $section->mobileImage) {
        $heroImgUrl = $section->mobileImage->url();
    } elseif ($section->image) {
        $heroImgUrl = asset('storage/' . $section->image);
    } elseif ($default = setting('store.default_hero_image')) {
        $heroImgUrl = asset('storage/' . $default);
    }

    $imgAlt  = $section->image_alt ?: ($section->title ?? 'Hero image');
    $overlay = $section->overlay_style ?? 'none';

    $overlayClass = match ($overlay) {
        'dark'     => 'bg-slate-900/50',
        'light'    => 'bg-white/30',
        'gradient' => 'bg-gradient-to-r from-slate-900/60 to-transparent',
        default    => '',
    };
@endphp

<section class="relative overflow-hidden bg-slate-100">
    {{-- Background image --}}
    @if ($heroImgUrl)
        <img src="{{ $heroImgUrl }}" alt="{{ $imgAlt }}"
             class="absolute inset-0 h-full w-full object-cover object-{{ $section->image_position ?? 'center' }}">
    @endif

    {{-- Overlay --}}
    @if ($overlayClass)
        <div class="absolute inset-0 {{ $overlayClass }}"></div>
    @endif

    {{-- Content --}}
    <div class="relative mx-auto grid max-w-6xl gap-8 px-6 py-16 lg:items-center lg:py-24 {{ $heroImgUrl ? 'text-white' : '' }}">
        <div class="max-w-2xl space-y-6">
            @if ($section->subtitle)
                <p class="inline-flex rounded-full border {{ $heroImgUrl ? 'border-white/30 bg-white/10 text-white/80' : 'border-slate-200 bg-slate-50 text-slate-600' }} px-4 py-2 text-sm font-semibold uppercase tracking-wide">
                    {{ $section->subtitle }}
                </p>
            @endif

            @if ($section->title)
                <h1 class="max-w-3xl text-4xl font-semibold tracking-tight {{ $heroImgUrl ? 'text-white' : 'text-slate-950' }} sm:text-5xl lg:text-6xl">
                    {{ $section->title }}
                </h1>
            @endif

            @if ($section->content)
                <p class="max-w-xl text-lg leading-8 {{ $heroImgUrl ? 'text-white/80' : 'text-slate-600' }}">
                    {{ $section->content }}
                </p>
            @endif

            @if ($section->button_text && $section->button_url)
                <a href="{{ $section->button_url }}"
                   class="inline-flex rounded-full px-6 py-3 text-sm font-semibold shadow-sm transition
                          {{ $heroImgUrl ? 'bg-white text-slate-900 hover:bg-slate-100' : 'bg-slate-950 text-white hover:bg-slate-700' }}">
                    {{ $section->button_text }}
                </a>
            @endif
        </div>
    </div>
</section>
