<form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input
                    id="file"
                    type="file"
                    name="file"
                    class="form-control @error('file') is-invalid @enderror"
                    accept=".jpg,.jpeg,.png,.webp,.gif,.pdf"
                    required
                >
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4">
            @include('admin.components.form.input', [
                'name' => 'alt_text',
                'label' => 'Alt Text',
                'value' => '',
            ])
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Upload Media</button>
</form>
