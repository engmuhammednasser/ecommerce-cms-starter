{{--
    Shared partial for selecting a media library image by ID.
    Variables:
    - $name        (string) Form field name
    - $label       (string) Label text
    - $selected    (int|null) Currently selected media ID
    - $mediaOptions (array) ['id' => 'filename'] options map
--}}
@php
    $fieldId = 'media_select_' . str_replace(['.', '[', ']'], '_', $name);
    $currentId = old($name, $selected ?? null);

    // Build URL for current preview if selected
    $previewUrl = null;
    if ($currentId) {
        $mediaRecord = \App\Models\Media::find($currentId);
        $previewUrl = $mediaRecord?->url();
    }
@endphp

<div class="mb-3">
    <label for="{{ $fieldId }}" class="form-label fw-semibold">{{ $label }}</label>

    <select id="{{ $fieldId }}" name="{{ $name }}" class="form-select @error($name) is-invalid @enderror"
        onchange="updateMediaPreview(this, '{{ $fieldId }}_preview')">
        <option value="">— None —</option>
        @foreach ($mediaOptions as $mediaId => $mediaName)
            <option value="{{ $mediaId }}" @selected((int)$currentId === (int)$mediaId)>
                {{ $mediaName }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    {{-- Preview thumbnail --}}
    <div id="{{ $fieldId }}_preview" class="mt-2" style="{{ $previewUrl ? '' : 'display:none' }}">
        @if ($previewUrl)
            <img src="{{ $previewUrl }}" alt="Preview" class="img-thumbnail" style="max-height:80px;">
        @else
            <img src="" alt="Preview" class="img-thumbnail" style="max-height:80px;">
        @endif
    </div>
</div>

@once
@push('scripts')
<script>
function updateMediaPreview(selectEl, previewId) {
    const previewWrap = document.getElementById(previewId);
    const img = previewWrap ? previewWrap.querySelector('img') : null;
    if (!previewWrap || !img) return;

    const selectedOpt = selectEl.options[selectEl.selectedIndex];
    if (!selectEl.value) {
        previewWrap.style.display = 'none';
        img.src = '';
        return;
    }

    // Attempt to fetch the URL by re-using a route or a data attribute
    // As a simple fallback the preview shows after save; hide old preview on change
    previewWrap.style.display = 'none';
    img.src = '';
}
</script>
@endpush
@endonce
