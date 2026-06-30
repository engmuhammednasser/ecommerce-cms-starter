@php
    $breadcrumbItems = $breadcrumbs ?? [['label' => 'Dashboard', 'url' => '#']];
@endphp

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mb-0">@yield('page_title', $breadcrumbItems[count($breadcrumbItems) - 1]['label'])</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    @foreach ($breadcrumbItems as $item)
                        @if ($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
