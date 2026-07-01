<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <button class="nav-link btn btn-link" type="button" data-lte-toggle="sidebar" aria-label="Toggle sidebar">
                    <svg class="admin-header-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">{{ setting('general.site_name', config('app.name', 'Laravel')) }}</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <span class="nav-link">{{ auth()->user()?->name ?? 'Admin' }}</span>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
