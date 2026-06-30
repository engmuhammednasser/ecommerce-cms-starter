<dl class="row mb-4">
    <dt class="col-sm-3">Type</dt>
    <dd class="col-sm-9">{{ ucfirst($template->type) }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">
        @include('admin.components.status-badge', [
            'status' => $template->is_active ? 'active' : 'inactive',
        ])
    </dd>

    <dt class="col-sm-3">Subject</dt>
    <dd class="col-sm-9">{{ $template->subject }}</dd>
</dl>

<h3 class="h6">Body</h3>
<pre class="bg-body-tertiary border rounded p-3 mb-0">{{ $template->body }}</pre>
