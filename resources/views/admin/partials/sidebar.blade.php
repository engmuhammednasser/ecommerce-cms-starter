<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    @php
        $active = fn (string|array $patterns): string => request()->routeIs($patterns) ? ' active' : '';
        $icons = [
            'dashboard' => '<path d="M3 13h8V3H3v10Zm10 8h8V3h-8v18ZM3 21h8v-6H3v6Z"/>',
            'page' => '<path d="M6 2h8l4 4v16H6V2Zm7 1v5h5"/>',
            'sections' => '<path d="M4 4h16v5H4V4Zm0 7h7v9H4v-9Zm9 0h7v9h-7v-9Z"/>',
            'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
            'media' => '<path d="M4 5h16v14H4V5Zm3 10 3-4 3 3 2-2 3 3"/>',
            'product' => '<path d="M4 7 12 3l8 4-8 4-8-4Zm0 3 8 4 8-4v7l-8 4-8-4v-7Z"/>',
            'category' => '<path d="M4 5h7v7H4V5Zm9 0h7v7h-7V5ZM4 14h7v5H4v-5Zm9 0h7v5h-7v-5Z"/>',
            'brand' => '<path d="M12 3 4 7v10l8 4 8-4V7l-8-4Zm0 4 4 2v6l-4 2-4-2V9l4-2Z"/>',
            'attribute' => '<path d="M5 7h14M7 12h10M9 17h6"/>',
            'inventory' => '<path d="M5 6h14v4H5V6Zm1 6h12v7H6v-7Zm3 3h6"/>',
            'order' => '<path d="M6 3h12v18H6V3Zm3 5h6M9 12h6M9 16h4"/>',
            'customer' => '<path d="M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0ZM4 21a8 8 0 0 1 16 0"/>',
            'coupon' => '<path d="M4 8V5h16v3a2 2 0 0 0 0 4v3H4v-3a2 2 0 0 0 0-4Zm6-1v10"/>',
            'appearance' => '<path d="M12 3a9 9 0 0 0 0 18h1.5a2 2 0 0 0 0-4H12a2 2 0 0 1 0-4h1a8 8 0 0 0 0-10h-1Z"/>',
            'settings' => '<path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm8 4a8 8 0 0 0-.2-1.8l2-1.5-2-3.4-2.4 1a8 8 0 0 0-3.1-1.8L14 2h-4l-.3 2.5a8 8 0 0 0-3.1 1.8l-2.4-1-2 3.4 2 1.5A8 8 0 0 0 4 12c0 .6.1 1.2.2 1.8l-2 1.5 2 3.4 2.4-1a8 8 0 0 0 3.1 1.8L10 22h4l.3-2.5a8 8 0 0 0 3.1-1.8l2.4 1 2-3.4-2-1.5c.1-.6.2-1.2.2-1.8Z"/>',
            'seo' => '<path d="M10 13a5 5 0 1 1 1.5-3.5M14 14l5 5M14 6h6M17 3v6"/>',
            'shipping' => '<path d="M3 7h11v9H3V7Zm11 3h4l3 3v3h-7v-6ZM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>',
            'payment' => '<path d="M3 6h18v12H3V6Zm0 4h18M7 15h4"/>',
            'tax' => '<path d="M6 18 18 6M8 8h.01M16 16h.01"/>',
            'email' => '<path d="M4 6h16v12H4V6Zm0 0 8 7 8-7"/>',
            'user' => '<path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0"/>',
            'role' => '<path d="M12 3 5 6v5c0 4.5 3 8 7 10 4-2 7-5.5 7-10V6l-7-3Z"/>',
            'permission' => '<path d="M8 11V8a4 4 0 0 1 8 0v3M6 11h12v10H6V11Z"/>',
            'logs' => '<path d="M6 3h12v18H6V3Zm3 5h6M9 12h6M9 16h3"/>',
            'export' => '<path d="M12 3v12m0 0 4-4m-4 4-4-4M5 19h14"/>',
            'maintenance' => '<path d="M14 7 17 4l3 3-3 3m-3-3-9 9v3h3l9-9"/>',
        ];
        $navIcon = fn (string $name): string => '<svg class="nav-icon admin-sidebar-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . ($icons[$name] ?? $icons['dashboard']) . '</g></svg>';
    @endphp

    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            @if (setting('general.logo'))
                <img src="{{ asset('storage/' . setting('general.logo')) }}" alt="{{ setting('general.site_name', config('app.name', 'Laravel')) }}" class="brand-image opacity-75 shadow">
            @endif
            <span class="brand-text fw-light">{{ setting('general.site_name', config('app.name', 'Laravel')) }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link{{ $active('admin.dashboard') }}">
                        {!! $navIcon('dashboard') !!}
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Content</li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link{{ $active('admin.pages.*') }}">{!! $navIcon('page') !!}<p>Pages</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sections.index') }}" class="nav-link{{ $active('admin.sections.*') }}">{!! $navIcon('sections') !!}<p>Homepage Sections</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link{{ $active('admin.menus.*') }}">{!! $navIcon('menu') !!}<p>Menus</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.media.index') }}" class="nav-link{{ $active('admin.media.*') }}">{!! $navIcon('media') !!}<p>Media Library</p></a>
                </li>

                <li class="nav-header">Catalog</li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link{{ $active('admin.products.*') }}">{!! $navIcon('product') !!}<p>Products</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link{{ $active('admin.categories.*') }}">{!! $navIcon('category') !!}<p>Categories</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link{{ $active('admin.brands.*') }}">{!! $navIcon('brand') !!}<p>Brands</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attributes.index') }}" class="nav-link{{ $active('admin.attributes.*') }}">{!! $navIcon('attribute') !!}<p>Attributes</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.inventory.index') }}" class="nav-link{{ $active('admin.inventory.*') }}">{!! $navIcon('inventory') !!}<p>Inventory</p></a>
                </li>

                <li class="nav-header">Sales</li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link{{ $active('admin.orders.*') }}">{!! $navIcon('order') !!}<p>Orders</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link{{ $active('admin.customers.*') }}">{!! $navIcon('customer') !!}<p>Customers</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.coupons.index') }}" class="nav-link{{ $active('admin.coupons.*') }}">{!! $navIcon('coupon') !!}<p>Coupons</p></a>
                </li>

                <li class="nav-header">Appearance</li>
                <li class="nav-item">
                    <a href="{{ route('admin.theme-settings.index') }}" class="nav-link{{ $active('admin.theme-settings.*') }}">{!! $navIcon('appearance') !!}<p>Theme Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.header-settings.index') }}" class="nav-link{{ $active('admin.header-settings.*') }}">{!! $navIcon('sections') !!}<p>Header Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.footer-settings.index') }}" class="nav-link{{ $active('admin.footer-settings.*') }}">{!! $navIcon('sections') !!}<p>Footer Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link{{ $active('admin.menus.*') }}">{!! $navIcon('menu') !!}<p>Menus</p></a>
                </li>

                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link{{ $active('admin.settings.*') }}">{!! $navIcon('settings') !!}<p>Store Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">{!! $navIcon('seo') !!}<p>SEO Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.shipping-zones.index') }}" class="nav-link{{ $active('admin.shipping-zones.*') }}">{!! $navIcon('shipping') !!}<p>Shipping Zones</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}#payment-settings" class="nav-link">{!! $navIcon('payment') !!}<p>Payment Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}#tax-settings" class="nav-link">{!! $navIcon('tax') !!}<p>Tax Settings</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.email-templates.index') }}" class="nav-link{{ $active('admin.email-templates.*') }}">{!! $navIcon('email') !!}<p>Email Templates</p></a>
                </li>

                <li class="nav-header">Users</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link{{ $active('admin.users.*') }}">{!! $navIcon('user') !!}<p>Admin Users</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">{!! $navIcon('role') !!}<p>Roles</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">{!! $navIcon('permission') !!}<p>Permissions</p></a>
                </li>

                <li class="nav-header">System</li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-logs.index') }}" class="nav-link{{ $active('admin.activity-logs.*') }}">{!! $navIcon('logs') !!}<p>Activity Logs</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.exports.index') }}" class="nav-link{{ $active('admin.exports.*') }}">{!! $navIcon('export') !!}<p>Export</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.maintenance.index') }}" class="nav-link{{ $active('admin.maintenance.*') }}">{!! $navIcon('maintenance') !!}<p>Maintenance</p></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
