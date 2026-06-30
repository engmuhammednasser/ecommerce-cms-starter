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

document.addEventListener('click', (event) => {
    const openButton = event.target.closest('[data-media-picker-open]');

    if (openButton) {
        mediaPickerTarget = document.getElementById(openButton.dataset.mediaPickerTarget);
        openMediaPickerModal();
    }

    if (event.target.closest('[data-media-picker-close]')) {
        closeMediaPickerModal();
    }

    const selectButton = event.target.closest('[data-media-picker-select]');

    if (! selectButton || ! mediaPickerTarget) {
        return;
    }

    mediaPickerTarget.value = selectButton.dataset.mediaPath || '';
    mediaPickerTarget.dispatchEvent(new Event('change', { bubbles: true }));

    const previewId = mediaPickerTarget.dataset.mediaPickerPreview;
    const preview = previewId ? document.getElementById(previewId) : null;

    if (preview && selectButton.dataset.mediaUrl) {
        preview.innerHTML = `<img src="${selectButton.dataset.mediaUrl}" alt="" class="img-thumbnail" style="width: 96px; height: 96px; object-fit: cover;">`;
    }

    closeMediaPickerModal();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeMediaPickerModal();
    }
});
