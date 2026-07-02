<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Services\EmailTemplateRenderer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    public function index(): View
    {
        $templates = EmailTemplate::query()
            ->orderBy('type')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.email-templates.index', compact('templates'));
    }

    public function show(EmailTemplate $emailTemplate): View
    {
        return view('admin.email-templates.show', compact('emailTemplate'));
    }

    public function edit(EmailTemplate $emailTemplate): View
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $emailTemplate->update($validated);

        return redirect()
            ->route('admin.email-templates.index')
            ->with('success', 'Email template updated successfully.');
    }

    public function preview(Request $request, EmailTemplateRenderer $renderer)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);

        $dummyData = [
            'store_name' => setting('general.site_name', config('app.name', 'Laravel')),
            'order_number' => 'ORD-12345678',
            'order_status' => 'Processing',
            'order_total' => '120.00',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '1234567890',
            'old_status' => 'Pending',
        ];

        // Ensure we parse the blade string
        $html = \Illuminate\Support\Facades\Blade::render($validated['body'], $dummyData);

        return response($html);
    }
}
