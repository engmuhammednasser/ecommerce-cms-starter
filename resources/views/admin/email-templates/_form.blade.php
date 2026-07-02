<form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate) }}" id="email-template-form">
    @csrf
    @method('PUT')

    @include('admin.components.form.input', [
        'name' => 'subject',
        'label' => 'Subject Line',
        'value' => old('subject', $emailTemplate->subject),
        'required' => true,
    ])

    <div class="mb-3">
        <label for="body" class="form-label">Email Body (Blade Template)</label>
        <textarea name="body" id="body" rows="15" class="form-control" required style="font-family: monospace;">{{ old('body', $emailTemplate->body) }}</textarea>
        @error('body')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-outline-secondary" onclick="previewTemplate()">
            <i class="fas fa-eye me-1"></i> Preview
        </button>
        <button type="submit" class="btn btn-primary">Save Template</button>
    </div>
</form>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Template Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewIframe" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    function previewTemplate() {
        const form = document.getElementById('email-template-form');
        const formData = new FormData(form);
        
        fetch('{{ route('admin.email-templates.preview') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'text/html'
            },
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            const iframe = document.getElementById('previewIframe');
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(html);
            iframe.contentWindow.document.close();
            
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        })
        .catch(error => {
            alert('Failed to load preview.');
            console.error(error);
        });
    }
</script>
