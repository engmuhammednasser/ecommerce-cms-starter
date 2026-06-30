<dl class="row mb-0">
    <dt class="col-sm-3">Type</dt>
    <dd class="col-sm-9">{{ $section->typeLabel() }}</dd>

    <dt class="col-sm-3">Title</dt>
    <dd class="col-sm-9">{{ $section->title ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Subtitle</dt>
    <dd class="col-sm-9">{{ $section->subtitle ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Related Page</dt>
    <dd class="col-sm-9">{{ $section->page?->title ?: 'Homepage / global' }}</dd>

    <dt class="col-sm-3">State</dt>
    <dd class="col-sm-9">
        @include('admin.components.status-badge', ['status' => $section->is_active ? 'active' : 'inactive'])
    </dd>

    <dt class="col-sm-3">Sort Order</dt>
    <dd class="col-sm-9">{{ $section->sort_order }}</dd>

    <dt class="col-sm-3">Content</dt>
    <dd class="col-sm-9">{!! nl2br(e($section->content ?: '')) !!}</dd>

    <dt class="col-sm-3">Image</dt>
    <dd class="col-sm-9">{{ $section->image ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Button</dt>
    <dd class="col-sm-9">{{ $section->button_text ?: 'Not set' }} {{ $section->button_url ? '(' . $section->button_url . ')' : '' }}</dd>

    <dt class="col-sm-3">Settings</dt>
    <dd class="col-sm-9">
        <pre class="bg-body-tertiary border rounded p-3 mb-0">{{ $section->settings ? json_encode($section->settings, JSON_PRETTY_PRINT) : 'Not set' }}</pre>
    </dd>
</dl>
