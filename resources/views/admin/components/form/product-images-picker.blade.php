@php
    $name = $name ?? 'image_paths';
    $id = $id ?? $name;
    $label = $label ?? 'Product Images';
    $value = old($name, $value ?? '');
    $paths = collect(preg_split('/\r\n|\r|\n/', (string) $value) ?: [])
        ->map(fn (string $path): string => trim($path))
        ->filter()
        ->values();
    $featuredPath = $paths->first();
    $galleryPaths = $paths->skip(1)->values();
@endphp

<div class="mb-3" data-product-images-picker data-product-images-input="{{ $id }}">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-control d-none @error($name) is-invalid @enderror"
        rows="4"
        data-product-images-value
        data-media-picker-preview="{{ $id }}_featured_preview"
    >{{ $value }}</textarea>

    <div class="row g-3">
        <div class="col-md-5">
            <div class="border rounded p-3 h-100">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <div class="fw-semibold">Featured Image</div>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-media-picker-open
                        data-media-picker-target="{{ $id }}"
                        data-media-picker-mode="featured"
                    >
                        {{ $featuredPath ? 'Update Featured' : 'Choose Featured' }}
                    </button>
                </div>

                <div id="{{ $id }}_featured_preview" data-product-images-featured-preview>
                    @if ($featuredPath)
                        <img src="{{ asset('storage/' . $featuredPath) }}" alt="Featured product image" class="img-thumbnail admin-product-featured-image">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" data-product-gallery-remove="{{ $featuredPath }}">Remove Featured</button>
                    @else
                        @include('admin.components.empty-state', [
                            'title' => 'No featured image',
                            'message' => 'Choose the main product image.',
                        ])
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="border rounded p-3 h-100">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <div class="fw-semibold">Gallery Images</div>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-media-picker-open
                        data-media-picker-target="{{ $id }}"
                        data-media-picker-mode="gallery"
                        data-media-picker-append
                    >
                        Add Gallery Image
                    </button>
                </div>

                <div class="row g-2" data-product-images-gallery-preview>
                    @forelse ($galleryPaths as $path)
                        <div class="col-6 col-lg-4" data-product-gallery-item="{{ $path }}">
                            <div class="border rounded p-2">
                                <img src="{{ asset('storage/' . $path) }}" alt="Product gallery image" class="img-fluid rounded mb-2" style="aspect-ratio: 1 / 1; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2" data-product-gallery-remove="{{ $path }}">Remove</button>
                            </div>
                        </div>
                    @empty
                        <div data-product-images-gallery-empty>
                            @include('admin.components.empty-state', [
                                'title' => 'No gallery images',
                                'message' => 'Add extra images for this product.',
                            ])
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="form-text">Choose a featured image and optional gallery images from the media library.</div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
