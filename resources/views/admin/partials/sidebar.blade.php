<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <span class="brand-text fw-light">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <span class="nav-icon">&bull;</span>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Content</li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Pages</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sections.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Homepage Sections</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Menus</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.media.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Media Library</p></a>
                </li>

                <li class="nav-header">Catalog</li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Products</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Categories</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Brands</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Attributes</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Inventory</p></a>
                </li>

                <li class="nav-header">Sales</li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Orders</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Customers</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Coupons</p></a>
                </li>

                <li class="nav-header">Appearance</li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Theme Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Header Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Footer Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Colors</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Menus</p></a>
                </li>

                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Store Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>SEO Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}#shipping-settings" class="nav-link"><span class="nav-icon">&bull;</span><p>Shipping Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}#payment-settings" class="nav-link"><span class="nav-icon">&bull;</span><p>Payment Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}#tax-settings" class="nav-link"><span class="nav-icon">&bull;</span><p>Tax Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.email-templates.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Email Templates</p></a>
                </li>

                <li class="nav-header">Users</li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Admin Users</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Roles</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><span class="nav-icon">&bull;</span><p>Permissions</p></a>
                </li>

                <li class="nav-header">System</li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-logs.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Activity Logs</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.exports.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Export</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.maintenance.index') }}" class="nav-link"><span class="nav-icon">&bull;</span><p>Maintenance</p></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
