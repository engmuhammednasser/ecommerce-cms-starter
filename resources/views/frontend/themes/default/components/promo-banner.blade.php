@props([
    'title',
    'subtitle' => null,
    'buttonText' => null,
    'buttonUrl' => null,
    'backgroundImage' => null,
])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-12 sm:px-12 sm:py-16 lg:px-16 lg:py-20']) }}>
    @if($backgroundImage)
        <div class="absolute inset-0">
            <img src="{{ $backgroundImage }}" alt="" class="h-full w-full object-cover opacity-30">
        </div>
    @endif
    
    <div class="relative z-10 mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $title }}</h2>
        @if($subtitle)
            <p class="mt-4 text-lg text-slate-300">{{ $subtitle }}</p>
        @endif
        @if($buttonText && $buttonUrl)
            <div class="mt-8">
                <a href="{{ $buttonUrl }}" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
                    {{ $buttonText }}
                </a>
            </div>
        @endif
    </div>
</div>
