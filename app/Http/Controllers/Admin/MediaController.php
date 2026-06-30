<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaItems = Media::query()
            ->latest()
            ->paginate(24);

        return view('admin.media.index', compact('mediaItems'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $validated['file'];
        $path = $file->store('media', 'public');
        $mimeType = $file->getMimeType();

        Media::create([
            'disk' => 'public',
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_name' => basename($path),
            'mime_type' => $mimeType,
            'size' => $file->getSize() ?: 0,
            'type' => str_starts_with((string) $mimeType, 'image/') ? 'image' : 'document',
            'alt_text' => $validated['alt_text'] ?? null,
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
