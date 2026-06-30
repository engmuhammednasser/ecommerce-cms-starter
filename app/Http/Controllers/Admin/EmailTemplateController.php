<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
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
}
