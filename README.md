# Laravel E-commerce CMS Starter Kit

A reusable Laravel E-commerce CMS starter kit with a custom WordPress-like admin experience. The admin UI uses AdminLTE for layout and visual components only; the architecture, routing, modules, database design, and business logic remain custom Laravel.

## Current Features

- Custom admin login and protected admin dashboard
- Custom roles and permissions with permission middleware for admin modules
- Settings system with editable store, SEO, shipping, payment, and tax values
- Media library with public storage uploads
- CMS pages, homepage sections, and menu builder
- Categories and products with SEO fields and product images
- Storefront theme structure with home, shop, category, product, cart, checkout, order success, contact, and page templates
- Session cart, basic checkout, order creation, order management, and customer list/details
- Demo data and demo media seeders
- SEO meta rendering for pages, products, categories, and global fallback settings
- Activity logs, CSV exports, and System / Maintenance page

## Requirements

- PHP 8.3 or newer
- PHP extensions: PDO, pdo_sqlite for local/demo setup, pdo_mysql for MySQL deployments
- Composer
- Node.js and npm
- SQLite for local/demo setup
- MySQL for staging/production stores

## Local Install: Windows PowerShell

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database/database.sqlite -Force
$env:DB_CONNECTION="sqlite"; php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Open the app at:

```txt
http://127.0.0.1:8000
```

## Local Install: Unix Shells

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
DB_CONNECTION=sqlite php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Open the app at:

```txt
http://127.0.0.1:8000
```

## Database Setup

SQLite is the default database for local development, demo installation, and quick preview.

The default `.env.example` uses:

```env
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

Laravel uses `database/database.sqlite` by default when `DB_DATABASE` is not set.

MySQL is recommended for staging and production stores. Update `.env` with production credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store_db
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate:fresh --seed
```

## Default Admin Login

The demo admin user is created by the seeders for local/demo use only.

```txt
URL: /admin/login
Email: admin@example.com
Password: password
```

## Tests and Assets

Run the Laravel test suite:

```bash
php artisan test
```

Run a full SQLite migration and seed pass:

```bash
php artisan migrate:fresh --seed
```

On Windows PowerShell:

```powershell
$env:DB_CONNECTION="sqlite"; php artisan migrate:fresh --seed
```

Build frontend and admin assets:

```bash
npm run build
```

During development:

```bash
npm run dev
```

## Project Structure

```txt
app/
  Http/
    Controllers/Admin/      Admin module controllers
    Controllers/Frontend/   Storefront controllers
    Middleware/             Admin auth and permission middleware
  Models/                   Eloquent models
  Services/                 Small application services
  Support/                  Helpers and support classes
database/
  migrations/               SQLite/MySQL compatible migrations
  seeders/                  Demo and foundation seeders
  demo-media/               Source demo media assets
resources/
  css/ js/                  Vite assets
  views/admin/              AdminLTE-based admin views
  views/frontend/themes/    Storefront theme files
routes/
  web.php                   Storefront and admin routes
storage/app/public/         Public media storage target
```

## Admin Modules

Admin routes live under `/admin` and use custom Laravel controllers and Blade views. Existing module pages follow this pattern where relevant:

```txt
index.blade.php
create.blade.php
edit.blade.php
show.blade.php
_form.blade.php
_filters.blade.php
```

Reusable admin UI lives in:

```txt
resources/views/admin/components/
resources/views/admin/partials/
```

AdminLTE is used only for layout and UI components such as cards, tables, forms, badges, alerts, and sidebar/header/footer structure.

## Settings

Settings are database-backed through the `settings` table and editable in the admin settings page. Use the global helper for theme/store values:

```php
setting('general.site_name', 'Laravel')
setting('seo.default_title')
setting('theme.primary_color')
```

Do not hardcode editable storefront values in Blade. Put editable values in settings, pages, sections, menus, media, products, or categories.

## Media

The media library stores uploaded files in public storage and records metadata in the database. Run this once after installation:

```bash
php artisan storage:link
```

Demo media is seeded from `database/demo-media/` and registered in the media table. Storefront images should reference database-backed paths, usually with:

```blade
{{ asset('storage/' . $path) }}
```

## Pages and Homepage Sections

CMS pages are managed from the admin panel and include SEO fields. Homepage sections are database-backed page sections. The frontend renders active sections through theme partials in:

```txt
resources/views/frontend/themes/default/sections/
```

Section content should come from `page_sections` records, not hardcoded storefront Blade content.

## Menus

Menus and menu items are database-backed. Header, footer, and mobile menus are seeded and editable from the admin panel. Storefront navigation reads menu records instead of hardcoded links.

## Demo Data

The project is demo-ready after seeding. Demo seeders create:

- Admin user
- Roles and permissions
- Store/settings defaults
- Demo media records
- CMS pages
- Homepage sections
- Menus
- Categories
- Products with images
- Customers
- Orders
- SEO defaults

Run:

```bash
php artisan migrate:fresh --seed
```

## Storefront Theme Structure

The default storefront theme lives in:

```txt
resources/views/frontend/themes/default/
```

The theme contains layouts, partials, page templates, catalog partials, and section partials. Global values such as store name, SEO defaults, menus, and footer text should come from settings or database-backed models.

To customize the theme, edit the default theme views or add a future theme folder following the same structure.

## Adding a New Admin Module

When adding a new admin module:

1. Add a migration using Laravel schema builder and SQLite/MySQL-compatible column types.
2. Add an Eloquent model with explicit fillable fields.
3. Add an admin controller with focused actions.
4. Add protected admin routes under `/admin`.
5. Add permission protection using the existing custom roles/permissions middleware.
6. Add Blade views using the existing admin layout and reusable components.
7. Include empty states, validation errors, flash messages, and confirmations for destructive actions.
8. Add seed data only when the module needs demo content.
9. Run `php artisan test`, `php artisan migrate:fresh --seed`, and `npm run build`.

Do not add a module without routes, controller, validation, views, and permission coverage.

## Important Rules

- Do not use Filament, Laravel Nova, Bagisto, Aimeos, Statamic, Twill, or a full CMS/e-commerce platform.
- AdminLTE is UI only; it must not define the architecture.
- SQLite must remain the default local/demo database.
- MySQL is recommended for staging and production.
- Keep migrations and seeders compatible with SQLite and MySQL whenever possible.
- Use string status columns, not database-level enum columns.
- Avoid database-specific raw SQL.
- Keep editable storefront content database-backed or settings-backed.
- Do not hardcode homepage, navigation, media, product, category, or page content in Blade.

## Useful Commands

```bash
php artisan route:list
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan test
npm run build
```
