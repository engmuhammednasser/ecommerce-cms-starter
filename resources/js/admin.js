import 'admin-lte/dist/js/adminlte.js';

let mediaPickerTarget = null;

const mediaPickerModal = () => document.getElementById('adminMediaPickerModal');

const openMediaPickerModal = () => {
    const modalElement = mediaPickerModal();

    if (! modalElement) {
        return;
    }

    modalElement.classList.add('show');
    modalElement.style.display = 'block';
    modalElement.removeAttribute('aria-hidden');
    modalElement.setAttribute('aria-modal', 'true');
    document.body.classList.add('modal-open');
};

const closeMediaPickerModal = () => {
    const modalElement = mediaPickerModal();

    if (! modalElement) {
        return;
    }

    modalElement.classList.remove('show');
    modalElement.style.display = 'none';
    modalElement.setAttribute('aria-hidden', 'true');
    modalElement.removeAttribute('aria-modal');
    document.body.classList.remove('modal-open');
};

const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const mediaPickerImageUrl = (path, url = '') => url || `/storage/${path}`;

const renderMediaPickerPreview = (input, url = '') => {
    const previewId = input.dataset.mediaPickerPreview;
    const preview = previewId ? document.getElementById(previewId) : null;
    const field = input.closest('[data-media-picker-field]');
    const openButton = field?.querySelector('[data-media-picker-open]');
    const removeButton = field?.querySelector('[data-media-picker-remove]');
    const path = input.value.trim();

    if (preview) {
        preview.innerHTML = path
            ? `<img src="${escapeHtml(mediaPickerImageUrl(path, url))}" alt="" class="img-thumbnail admin-media-picker-image">`
            : `<div class="admin-media-picker-empty text-center text-muted border rounded p-4"><div class="fw-semibold text-body">No image selected</div><div class="small">Choose an image from the media library.</div></div>`;
    }

    if (openButton) {
        openButton.textContent = path ? 'Update Image' : 'Choose Image';
    }

    if (removeButton) {
        removeButton.classList.toggle('d-none', ! path);
    }
};

const selectMediaPath = (path, url) => {
    if (! mediaPickerTarget) {
        return;
    }

    const appendMode = mediaPickerTarget.dataset.mediaPickerAppendMode === 'true';
    const pickerMode = mediaPickerTarget.dataset.mediaPickerMode;

    if (pickerMode === 'featured') {
        const paths = mediaPickerTarget.value.split(/\r?\n/).map((item) => item.trim()).filter(Boolean);
        const rest = paths.filter((item) => item !== path).slice(1);
        mediaPickerTarget.value = [path, ...rest].join('\n');
    } else if (appendMode) {
        const currentValue = mediaPickerTarget.value.trim();
        const paths = currentValue ? currentValue.split(/\r?\n/).map((item) => item.trim()).filter(Boolean) : [];

        if (! paths.includes(path)) {
            paths.push(path);
        }

        mediaPickerTarget.value = paths.join('\n');
    } else {
        mediaPickerTarget.value = path;
    }

    mediaPickerTarget.dispatchEvent(new Event('change', { bubbles: true }));

    if (! appendMode) {
        renderMediaPickerPreview(mediaPickerTarget, url);
    }

    renderProductImagesPicker(mediaPickerTarget);
};

const prependMediaPickerItem = (media) => {
    const grid = document.querySelector('[data-media-picker-grid]');

    if (! grid) {
        return;
    }

    document.querySelector('[data-media-picker-empty]')?.remove();

    const wrapper = document.createElement('div');
    wrapper.className = 'col-6 col-md-4 col-lg-3';
    wrapper.innerHTML = `
        <button
            type="button"
            class="btn btn-light border w-100 h-100 p-2 text-start"
            data-media-picker-select
            data-media-path="${escapeHtml(media.path)}"
            data-media-url="${escapeHtml(media.url)}"
        >
            <img src="${escapeHtml(media.url)}" alt="${escapeHtml(media.alt_text || media.original_name || '')}" class="img-fluid rounded mb-2" style="aspect-ratio: 1 / 1; object-fit: cover;">
            <span class="d-block small fw-semibold text-truncate">${escapeHtml(media.original_name || media.path)}</span>
            <span class="d-block small text-muted text-truncate">${escapeHtml(media.path)}</span>
        </button>
    `;

    grid.prepend(wrapper);
};

document.addEventListener('click', (event) => {
    const passwordToggle = event.target.closest('[data-password-toggle]');

    if (passwordToggle) {
        const passwordInput = document.getElementById(passwordToggle.dataset.passwordTarget);
        const label = passwordToggle.querySelector('[data-password-toggle-label]');

        if (passwordInput) {
            const shouldShow = passwordInput.type === 'password';
            passwordInput.type = shouldShow ? 'text' : 'password';
            passwordToggle.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');

            if (label) {
                label.textContent = shouldShow ? 'Hide' : 'Show';
            }
        }
    }

    const openButton = event.target.closest('[data-media-picker-open]');

    if (openButton) {
        mediaPickerTarget = document.getElementById(openButton.dataset.mediaPickerTarget);
        if (mediaPickerTarget) {
            mediaPickerTarget.dataset.mediaPickerAppendMode = openButton.hasAttribute('data-media-picker-append') ? 'true' : 'false';
            mediaPickerTarget.dataset.mediaPickerMode = openButton.dataset.mediaPickerMode || '';
        }
        openMediaPickerModal();
    }

    if (event.target.closest('[data-media-picker-close]')) {
        closeMediaPickerModal();
    }

    const removeMediaButton = event.target.closest('[data-media-picker-remove]');

    if (removeMediaButton) {
        const input = document.getElementById(removeMediaButton.dataset.mediaPickerTarget);

        if (input) {
            input.value = '';
            input.dispatchEvent(new Event('change', { bubbles: true }));
            renderMediaPickerPreview(input);
            renderProductImagesPicker(input);
        }

        return;
    }

    const selectButton = event.target.closest('[data-media-picker-select]');

    if (! selectButton || ! mediaPickerTarget) {
        return;
    }

    selectMediaPath(selectButton.dataset.mediaPath || '', selectButton.dataset.mediaUrl || '');
    closeMediaPickerModal();
});

document.addEventListener('submit', async (event) => {
    const form = event.target.closest('[data-media-picker-upload-form]');

    if (! form) {
        return;
    }

    event.preventDefault();

    const message = form.querySelector('[data-media-picker-upload-message]');
    const button = form.querySelector('[data-media-picker-upload-button]');
    const formData = new FormData(form);

    if (message) {
        message.className = 'small mt-2 text-muted';
        message.textContent = 'Uploading...';
    }

    if (button) {
        button.disabled = true;
    }

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
            },
        });

        const data = await response.json();

        if (! response.ok) {
            throw new Error(data.message || 'Upload failed.');
        }

        if (! data.media?.is_image) {
            throw new Error('Please upload an image file.');
        }

        prependMediaPickerItem(data.media);
        selectMediaPath(data.media.path, data.media.url);
        form.reset();

        if (message) {
            message.className = 'small mt-2 text-success';
            message.textContent = data.message || 'Media uploaded successfully.';
        }
    } catch (error) {
        if (message) {
            message.className = 'small mt-2 text-danger';
            message.textContent = error.message || 'Upload failed.';
        }
    } finally {
        if (button) {
            button.disabled = false;
        }
    }
});

document.addEventListener('click', (event) => {
    const removeButton = event.target.closest('[data-product-gallery-remove]');

    if (! removeButton) {
        return;
    }

    const picker = removeButton.closest('[data-product-images-picker]');
    const input = picker ? document.getElementById(picker.dataset.productImagesInput) : null;

    if (! input) {
        return;
    }

    const removePath = removeButton.dataset.productGalleryRemove;
    const paths = input.value.split(/\r?\n/).map((path) => path.trim()).filter(Boolean);
    input.value = paths.filter((path) => path !== removePath).join('\n');
    renderProductImagesPicker(input);
});

const renderProductImagesPicker = (input) => {
    const picker = input.closest('[data-product-images-picker]');

    if (! picker) {
        return;
    }

    const paths = input.value.split(/\r?\n/).map((path) => path.trim()).filter(Boolean);
    const featuredPath = paths[0] || '';
    const galleryPaths = paths.slice(1);
    const featuredPreview = picker.querySelector('[data-product-images-featured-preview]');
    const galleryPreview = picker.querySelector('[data-product-images-gallery-preview]');

    if (featuredPreview) {
        featuredPreview.innerHTML = featuredPath
            ? `<img src="/storage/${featuredPath}" alt="Featured product image" class="img-thumbnail admin-product-featured-image"><button type="button" class="btn btn-sm btn-outline-danger mt-2" data-product-gallery-remove="${escapeHtml(featuredPath)}">Remove Featured</button>`
            : `<div class="text-center text-muted py-4"><h3 class="h5 text-body mb-2">No featured image</h3><p class="mb-0">Choose the main product image.</p></div>`;
    }

    if (galleryPreview) {
        galleryPreview.innerHTML = galleryPaths.length
            ? galleryPaths.map((path) => `
                <div class="col-6 col-lg-4" data-product-gallery-item="${path}">
                    <div class="border rounded p-2">
                        <img src="/storage/${path}" alt="Product gallery image" class="img-fluid rounded mb-2" style="aspect-ratio: 1 / 1; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2" data-product-gallery-remove="${path}">Remove</button>
                    </div>
                </div>
            `).join('')
            : `<div data-product-images-gallery-empty><div class="text-center text-muted py-4"><h3 class="h5 text-body mb-2">No gallery images</h3><p class="mb-0">Add extra images for this product.</p></div></div>`;
    }
};

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeMediaPickerModal();
    }
});
