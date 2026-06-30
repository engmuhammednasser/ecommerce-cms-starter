<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <button class="nav-link btn btn-link" type="button" data-lte-toggle="sidebar" aria-label="Toggle sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Dashboard</a>
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
