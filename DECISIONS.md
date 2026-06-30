# DECISIONS.md

This file contains the fixed project decisions for the Laravel E-commerce CMS Starter Kit.
These decisions are not suggestions. They must be followed by Codex and any AI coding agent.

## Product Direction

- Build a reusable Laravel E-commerce CMS Starter Kit.
- The project should be used as a base for future online stores.
- The admin experience should be organized like WordPress, but built with custom Laravel architecture.
- The project must be demo-ready after installation, not empty.
- All demo content must be editable later from the dashboard.

## Admin Dashboard

- Use AdminLTE as the admin UI base.
- Use AdminLTE only for layout and visual components.
- Do not let AdminLTE define architecture.
- Do not use Filament.
- Do not use Laravel Nova.
- Do not use a full ready-made CMS/e-commerce platform as the project base.

## Architecture

- Laravel custom architecture.
- Blade-based admin and storefront views are acceptable.
- Reusable Blade components/partials are required for repeated admin UI.
- Modules should be separated clearly by responsibility.
- Avoid large monolithic controllers, views, services, or route files.

## Database

- SQLite is the default for local/demo/quick preview.
- MySQL is recommended for staging and production.
- Migrations and seeders must remain compatible with both whenever possible.
- Use Laravel migrations and Eloquent instead of database-specific SQL.
- Prefer string status columns over database enum columns.
- Avoid engine-specific full-text indexes unless documented and guarded.

## Required Core Modules

- Authentication
- Admin dashboard
- Settings system
- Media library
- CMS pages
- Homepage sections / simple page builder
- Menu builder
- Products
- Categories
- Orders
- Cart
- Checkout
- Customers
- Theme and store settings
- Roles and permissions
- SEO system
- Email templates
- Shipping, payment, and tax settings
- Activity logs
- Export preparation
- System / maintenance
- Documentation

## Required Frontend Pages

- Home
- Shop
- Product details
- Category products
- Cart
- Checkout
- Order success
- Login
- Register
- Contact
- Static page template

## Required Admin Sidebar Groups

- Dashboard
- Content
- Catalog
- Sales
- Appearance
- Settings
- Users
- System

## Demo Data

The starter kit must include seeders for:

- Admin user
- Settings
- Demo media
- Pages
- Page sections
- Menus
- Categories
- Products
- Customers
- Orders
- Email templates
- SEO defaults

## Content Rules

- No primary frontend content should be hardcoded in Blade.
- Logo, favicon, colors, contact info, footer text, social links, homepage content, page content, product data, category data, and menus must be editable from admin.
- Storefront pages must read from the database-backed CMS/settings systems.

## UI/UX Rules

- Admin pages must have clean internal UI.
- Every module should have list/create/edit/show pages where relevant.
- Tables should include search, filters, pagination, status badges, and action buttons where relevant.
- Empty states are required.
- Error states are required.
- Destructive actions require confirmation.
- Flash messages are required for create/update/delete/status actions.

## Implementation Style

- Keep changes small and scoped.
- Implement one task at a time.
- Do not implement future tasks early.
- Do not rewrite unrelated files.
- Do not make speculative architecture changes.
- Document important implementation decisions.
