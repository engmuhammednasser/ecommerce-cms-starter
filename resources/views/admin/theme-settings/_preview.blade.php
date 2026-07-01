<div class="theme-preview rounded border overflow-hidden">
    <div class="p-4 text-white" style="background: {{ $primaryColor }};">
        <div class="small opacity-75">Primary</div>
        <div class="fw-semibold">{{ $primaryColor }}</div>
    </div>
    <div class="p-4 text-white" style="background: {{ $secondaryColor }};">
        <div class="small opacity-75">Secondary</div>
        <div class="fw-semibold">{{ $secondaryColor }}</div>
    </div>
    <div class="p-4 bg-body">
        <button type="button" class="btn text-white me-2" style="background: {{ $primaryColor }};">Primary Button</button>
        <button type="button" class="btn text-white" style="background: {{ $secondaryColor }};">Secondary</button>
    </div>
</div>
