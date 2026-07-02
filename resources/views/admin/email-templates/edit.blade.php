@extends('admin.layouts.app')

@section('title', 'Edit Email Template')
@section('page_title', 'Edit Email Template: ' . $emailTemplate->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Email Templates', 'url' => route('admin.email-templates.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.card', [
                'title' => 'Edit Template Details',
                'slot' => view('admin.email-templates._form', ['emailTemplate' => $emailTemplate])->render(),
            ])
        </div>
        <div class="col-lg-4">
            @include('admin.components.card', [
                'title' => 'Available Variables',
                'slot' => '
                    <ul class="list-unstyled mb-0">
                        <li><code>$store_name</code></li>
                        <li><code>$order_number</code></li>
                        <li><code>$order_status</code></li>
                        <li><code>$order_total</code></li>
                        <li><code>$customer_name</code></li>
                        <li><code>$customer_email</code></li>
                        <li><code>$customer_phone</code></li>
                        <li><code>$old_status</code> (status change only)</li>
                    </ul>
                ',
            ])
        </div>
    </div>
@endsection
