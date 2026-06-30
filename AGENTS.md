# AGENTS.md

This repository is a reusable Laravel E-commerce CMS Starter Kit.

Codex and any AI coding agent must follow this file before making changes.

## Required Reading Order

Before editing code, read only the files needed for the current task, in this order:

1. `DECISIONS.md`
2. `TASKS.md`
3. `LARAVEL_ECOMMERCE_CMS_STARTER_SPEC.md` only for the sections related to the active task
4. Existing project files directly related to the active task

Do not read or print large unrelated files. Use search tools such as `rg`, `find`, or file names to locate relevant code.

## Source of Truth

`LARAVEL_ECOMMERCE_CMS_STARTER_SPEC.md` is the full project contract.
`DECISIONS.md` is the short non-negotiable decision list.
`TASKS.md` is the execution plan.

If there is a conflict:

1. `DECISIONS.md` wins for fixed architecture decisions.
2. `LARAVEL_ECOMMERCE_CMS_STARTER_SPEC.md` wins for detailed requirements.
3. `TASKS.md` controls the current execution scope.

Do not silently change agreed decisions.

## Main Goal

Build a reusable Laravel E-commerce CMS Starter Kit with a WordPress-like admin experience.
The admin panel must be custom Laravel, using AdminLTE only as UI/layout/components.

## Non-Negotiable Rules

- Do not use Filament.
- Do not use Laravel Nova.
- Do not use Bagisto, Aimeos, Statamic, Twill, or any full CMS/e-commerce platform unless the spec is explicitly changed.
- Do not let AdminLTE control architecture.
- Do not hardcode frontend demo content in Blade templates.
- Do not build one huge controller or one huge view.
- Do not implement features outside the active task.
- Do not refactor unrelated files.
- Do not rename routes, tables, models, or controllers unless the active task requires it.
- Do not add packages without checking that they fit the spec.
- Do not add database-engine-specific SQL unless documented and unavoidable.

## Database Policy

- SQLite is the default database for local demo installation and quick preview.
- MySQL is the recommended database for staging and production stores.
- Migrations and seeders must work on both SQLite and MySQL whenever possible.
- Prefer Laravel schema builder and Eloquent.
- Prefer `string` status columns over database-level `enum` fields.
- Avoid raw SQL.
- Be careful with JSON columns, full-text indexes, and engine-specific behavior.

## AdminLTE Usage

AdminLTE may be used for:

- Layout
- Sidebar
- Header/navbar
- Footer
- Cards
- Tables
- Forms
- Badges
- Modals
- Alerts
- Dashboard widgets

AdminLTE must not decide project architecture, route structure, module structure, database structure, or business logic.

## Required Admin Sidebar Structure

The admin sidebar should follow this structure:

```txt
Dashboard

Content
- Pages
- Homepage Sections
- Menus
- Media Library

Catalog
- Products
- Categories
- Brands
- Attributes
- Inventory

Sales
- Orders
- Customers
- Coupons

Appearance
- Theme Settings
- Header Settings
- Footer Settings
- Colors

Settings
- Store Settings
- SEO Settings
- Shipping Settings
- Payment Settings
- Tax Settings
- Email Templates

Users
- Admin Users
- Roles
- Permissions

System
- Activity Logs
- Export
- Maintenance
```

## Content Rules

All editable frontend content must come from database-backed systems:

- Settings
- Pages
- Page sections
- Menus
- Media library
- Products
- Categories

Bad example:

```blade
<h1>Summer Sale</h1>
<img src="/demo/banner.jpg">
```

Good example:

```blade
<h1>{{ $section->title }}</h1>
<img src="{{ asset('storage/' . $section->image) }}">
```

## Required Module Page Pattern

Every admin module should follow this page pattern where relevant:

```txt
index.blade.php   -> list/table/search/filter/pagination
create.blade.php  -> create form
edit.blade.php    -> edit form
show.blade.php    -> details page
_form.blade.php   -> shared form
_filters.blade.php -> filters when needed
```

Every list page must include empty states. Destructive actions must require confirmation.

## Required Reusable Admin Components

Prefer reusable Blade components/partials for repeated UI:

```txt
admin.components.card
admin.components.table
admin.components.form.input
admin.components.form.select
admin.components.form.textarea
admin.components.form.image-upload
admin.components.status-badge
admin.components.empty-state
admin.components.confirm-delete
admin.components.breadcrumb
admin.components.flash
```

## Demo Experience Rules

The project must not feel empty after installation.
It must ship with demo data and demo media that can be edited later from the dashboard.

Required demo content:

- Admin user
- Store settings
- Logo and favicon
- Homepage sections
- CMS pages
- Menus
- Categories
- Products with images
- Demo orders
- Demo customers
- SEO defaults
- Example email templates

Demo images must be replaceable from the admin dashboard and referenced from storage/database, not hardcoded.

## Task Execution Rules

When implementing a task:

1. Read the task from `TASKS.md`.
2. Implement only that task.
3. Keep the diff small.
4. Do not implement future tasks early.
5. Run the most relevant checks available.
6. Update the task status in `TASKS.md`.
7. Mention any skipped check honestly.

## Suggested Commands

Use relevant commands depending on the files changed:

```bash
php artisan test
php artisan migrate:fresh --seed
php artisan route:list
php artisan view:clear
php artisan config:clear
npm run build
```

For database compatibility, when possible test with both:

```bash
DB_CONNECTION=sqlite php artisan migrate:fresh --seed
DB_CONNECTION=mysql php artisan migrate:fresh --seed
```

## Required Final Response Format

After each task, respond only with:

```txt
Summary:
- ...

Changed files:
- ...

Tests:
- ...

Notes:
- ...
```

Do not paste large code blocks unless specifically requested.

## Stop Conditions

Stop and report instead of guessing if:

- A requested change conflicts with `DECISIONS.md` or the main spec.
- A required file is missing and cannot be inferred safely.
- The task would require changing architecture decisions.
- A package/license/security concern appears.

## Token Saving Policy

Use the lowest capable model and lowest sufficient reasoning effort.

Use low reasoning for:
- small scoped tasks
- Blade/UI edits
- markdown updates
- simple migrations
- simple seeders
- small controller changes

Use medium reasoning for:
- new modules
- multi-file CRUD implementation
- route/controller/model/view coordination
- tests

Use high reasoning only for:
- architecture decisions
- security-sensitive changes
- permissions
- checkout/order flow
- complex bugs
- large refactors

Do not use high reasoning for documentation-only or formatting tasks.