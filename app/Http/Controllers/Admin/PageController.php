<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $pages = Page::query()
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create', ['page' => new Page()]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $page = Page::create($this->validatedData($request));
        $activityLogger->log('page_created', $page);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): View
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldStatus = $page->status;
        $page->update($this->validatedData($request, $page));
        $activityLogger->log('page_updated', $page, [
            'status' => [$oldStatus, $page->status],
        ]);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('page_deleted', $page);
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Page $page = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('title')));
        $request->merge(['slug' => $slug]);

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'meta_robots' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
