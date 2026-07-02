# Project Handoff

> Last updated: 2026-07-02  
> Branch: `product-store`  
> Repository: https://github.com/engmuhammednasser/ecommerce-cms-starter

---

## Current Repository Structure

| Branch / Tag | Purpose |
|---|---|
| `main` | Clean, empty dashboard / starter-kit baseline. No store-specific data. |
| `v1.0-starter-stable` | Protected Git tag — snapshot of the stable starter kit before Awalad customization. |
| `product-store` | Active development branch. Contains the Awalad Farouk real store customizations. |

> ⚠️ Do **not** merge `product-store` into `main` unless you intentionally want to make Awalad-specific work part of the generic starter kit.

---

## How To Clone The Empty Dashboard

> Use this when you want a **clean, empty CMS starter kit** with no imported catalog data.

Clone from the stable tag `v1.0-starter-stable` (recommended) or from `main`:

```powershell
cd C:\xampp\htdocs
git clone --branch v1.0-starter-stable https://github.com/engmuhammednasser/ecommerce-cms-starter.git dashboard-empty
cd dashboard-empty
composer install
npm install && npm run build
copy .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
```

After migration, optionally seed demo data:

```powershell
php artisan db:seed
```

Then open `http://localhost/dashboard-empty/public` or run:

```powershell
php artisan serve
```

> ⚠️ Do **not** clone from `product-store` if you want the empty dashboard.  
> `product-store` contains Awalad Farouk-specific Arabic UI, imported catalog commands, and RTL layout changes that are not part of the generic starter kit.

---

## How To Clone The Awalad Farouk Store Branch

> Use this when you want to continue working on the **real Awalad Farouk store customization**.

```powershell
cd C:\xampp\htdocs
git clone --branch product-store https://github.com/engmuhammednasser/ecommerce-cms-starter.git awalad-store
cd awalad-store
composer install
npm install && npm run build
copy .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
```

After migration, you will need to re-import the Awalad Farouk catalog data from the source project at `C:\xampp\htdocs\awalad-farouk` (the database and media are **not committed** to Git):

```powershell
php artisan import:awalad --dry-run --only=categories,products,media
php artisan import:awalad --only=categories,products,media
php artisan catalog:clean-awalad
```

> ⚠️ The SQLite database and imported media files are **local runtime data**.  
> They are excluded by `.gitignore` and must be re-imported after a fresh clone.

---

## Stable Baseline

The starter-kit baseline was completed and saved as:

- **Branch**: `main`  
- **Tag**: `v1.0-starter-stable`

The tag marks a clean, reusable CMS foundation with no store-specific catalog data.

---

## Completed Core Features (Starter Kit)

The following features were implemented as part of the starter kit before Awalad customization:

- Admin dashboard foundation (AdminLTE-based)
- Products CRUD with categories, brands, attributes
- Product variants foundation
- Media library (upload, manage, link to products/categories)
- Order management + lifecycle (pending → completed)
- Order invoices (printable)
- Order items with unit/line totals
- Payments foundation (payment status tracking)
- Shipping zones and rates (per-governorate)
- Inventory management foundation
- Customer account area (login, orders, dashboard)
- Storefront: search, filters, sorting, pagination
- Visual media structure (TASK-055A through TASK-055D):
  - `main_image_id`, `hover_image_id`, `seo_image_id` on Product
  - `cover_image_id` on Category
  - Admin UI for assigning media to products/categories
  - Storefront rendering rules using Media relationships
- Email template foundation
- SEO fields on products and categories

---

## Homepage History

> **Important**: Previous homepage redesign attempts were made and then rejected/reverted.

- The live homepage (`/`) must remain **PageSection-driven** — it pulls data from the `page_sections` table.
- Do **not** hardcode content into the homepage Blade template.
- **TASK-051** (homepage commercial redesign) has **not** been completed. It was placed on hold and should only be resumed after:
  1. The shop/category pages are fully polished.
  2. A `/preview/home` route is used for safe previewing before going live.

---

## Awalad Farouk Import Work

### Source Project
- **Path on disk**: `C:\xampp\htdocs\awalad-farouk`
- **Audit file**: `docs/import-awalad-audit.md` (maps old tables → new CMS structure)

### Import Commands
```bash
# Safe dry-run before importing
php artisan import:awalad --dry-run --only=categories,products,media

# Real import (idempotent — safe to re-run)
php artisan import:awalad --only=categories,products,media

# Fix missing category references and assign cover images
php artisan catalog:clean-awalad --dry-run
php artisan catalog:clean-awalad
```

### What Was Imported (locally, not committed)
| Entity | Count |
|---|---|
| Products | ~2,949 |
| Categories | ~181 (includes ~156 nested) |
| Media records | ~4,830 |

### What Was Intentionally Skipped
- Customers
- Orders / order history
- Passwords
- Payment records

### Runtime Data Policy
> **The SQLite database and imported media files are LOCAL runtime data.**  
> They must NOT be committed to Git unless explicitly approved.  
> They are excluded by `.gitignore` and `database/.gitignore`.

---

## Arabic / RTL Work (TASK-P004)

The following changes were made to make the storefront and admin Arabic-first:

### Translation Files Created
- `resources/lang/ar/store.php` — storefront UI labels (shop, filters, sort, badges)
- `resources/lang/ar/admin.php` — admin sidebar, dashboard, common labels
- `resources/lang/ar/statuses.php` — status display labels (pending, completed, etc.)

### RTL Direction
- Frontend layout (`layouts/app.blade.php`): `lang="ar"` `dir="rtl"`
- Admin layout (`layouts/app.blade.php`): `lang="ar"` `dir="rtl"`

### Cairo Font
- Loaded from Google Fonts in both frontend and admin layouts
- Applied globally via inline `<style>` block

### Localized Views (Partial)
- Header: "My Account" / "Sign in"
- Shop filters: search, categories, price range, availability, apply/clear
- Sort dropdown: all options
- Shop page: category navigation header, results count, empty state
- Category page: subcategories label, product count, results, empty state
- Product card badges: Sale, Featured, Out of Stock
- Admin sidebar: Dashboard, Catalog, Products, Categories, Orders, Customers, Settings, Media

### Currency Status
> ⚠️ **Currency was intentionally NOT changed in TASK-P004.**  
> Egyptian Pound (ج.م) formatting was deferred to a separate task.  
> The `price.blade.php` component now reads `setting('store.currency_symbol', 'ج.م')`.  
> The DB setting `store.currency_symbol = ج.م` was inserted locally.

### Database Content
> Database content (product names, category names, descriptions) was **NOT translated**.  
> All imported Arabic product/category data remains as-is from the Awalad Farouk source.

---

## Product Card / Images

### Changes Made
- `product-card.blade.php` was updated to:
  - Use `mainImage` (Media record, TASK-055A) as primary image
  - Use `hoverImage` as hover effect image
  - Fall back to legacy `primaryImage` (ProductImage gallery record)
  - Fall back to `setting('store.default_product_image')`
  - Final fallback: "No image" neutral placeholder
- Changed `object-cover` to `object-contain` with `p-2` to avoid cropping imported product images with varied dimensions
- Added `onerror="this.style.display='none'"` to gracefully hide broken image tags

### Known Remaining Issue
- Image fallback specifically for **imported Awalad images** (real physical files in `storage/app/public/imported/awalad/`) should be manually verified on `/shop` and category pages.
- Demo images (from the seeder) use a different path structure and may appear correctly while real imported images do not.

---

## Do Not Commit

The following files/directories must never be committed:

```
.env
database/database.sqlite
database/*.backup
storage/app/public/imported/awalad/*
storage/logs/*
vendor/*
node_modules/*
bootstrap/cache/*
```

These are already covered by `.gitignore` and `database/.gitignore`, but always double-check with `git status` before committing.

---

## How To Continue

Recommended next steps in order:

1. **Verify imported Awalad image URLs** — Open `/shop` in a browser and confirm real product images (not demo) appear. Check `storage/app/public/imported/awalad/` exists and is symlinked correctly.
2. **Finish product card image fallback** — Ensure no broken image icons appear for any product.
3. **Finish Arabic admin labels** — Admin forms, product/category edit pages, order detail pages still have English field labels.
4. **Egyptian Pound currency formatting** — Implement `ج.م` display across cart, checkout, order success, admin order tables. Consider a `money()` Blade helper.
5. **Polish product details page** — Verify layout, image gallery, variants selector, add-to-cart form.
6. **Polish cart and checkout** — Verify RTL layout, Arabic labels, shipping rate display.
7. **Homepage redesign (TASK-051)** — Only after steps 1–6 are solid. Use a `/preview/home` route for safe iteration before going live.
8. **Push after each meaningful milestone** — Push `product-store` only. Never push local SQLite/media.

---

## Useful Commands

```bash
# Clear cached views after any Blade change
php artisan view:clear

# Verify shop routes
php artisan route:list --path=shop

# Check storage link is correct
php artisan storage:link

# Dry-run import (inspect without modifying data)
php artisan import:awalad --dry-run --only=categories,products,media

# Clean up imported catalog (fix missing categories, assign cover images)
php artisan catalog:clean-awalad --dry-run
php artisan catalog:clean-awalad

# Count imported data in tinker
php artisan tinker --execute="echo 'Products: ' . App\Models\Product::count() . PHP_EOL . 'Categories: ' . App\Models\Category::count() . PHP_EOL . 'Media: ' . App\Models\Media::count();"

# Check a product's main image URL
php artisan tinker --execute="dump(App\Models\Product::whereNotNull('main_image_id')->with('mainImage')->first()?->mainImage?->url());"

# Check top-level categories
php artisan tinker --execute="dump(App\Models\Category::whereNull('parent_id')->count());"
```

---

## Last Known Warnings

> ⚠️ Do not merge `product-store` into `main` unless you intentionally want Awalad-specific work in the generic starter kit.

> ⚠️ Do not push the local SQLite database or imported media as Git code.

> ⚠️ Currency (ج.م) display is partially implemented. `price.blade.php` now appends `ج.م`, but `cart.blade.php`, `checkout.blade.php`, `order-success.blade.php`, and admin order tables still need the suffix added consistently.

> ⚠️ Some admin pages (product edit, category edit, order detail, form fields) still display English labels. Localization is partial.

> ⚠️ Product image fallback should be manually tested on `/shop` using imported Awalad product images specifically — not just demo seed images.

> ⚠️ TASK-051 (homepage redesign) is **not done**. The live homepage must remain PageSection-driven until this task is explicitly started and reviewed.
