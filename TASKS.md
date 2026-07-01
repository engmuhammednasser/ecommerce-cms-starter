# TASKS.md

This file is the Codex execution plan for the Laravel E-commerce CMS Starter Kit.

## How To Use This File

Work on one task only at a time.
Each Codex prompt should reference exactly one task ID.

Recommended prompt:

```txt
Read AGENTS.md, DECISIONS.md, and TASKS.md.
Implement TASK-XXX only.
Do not implement any future task.
Keep changes minimal and scoped.
Update TASKS.md status after implementation.
Return Summary, Changed files, Tests, Notes only.
```

Status values:

```txt
pending
in_progress
done
blocked
```

---

# Milestone 1: Project Foundation

## TASK-001: Create / verify Laravel project foundation

Status: done

Scope:
- Verify Laravel app structure.
- Verify `.env.example` exists.
- Add project README basics if missing.
- Do not implement admin modules yet.

Acceptance Criteria:
- Laravel project can install dependencies.
- `.env.example` documents SQLite default.
- README has basic setup commands.

Do Not:
- Do not add products, orders, CMS, or frontend pages.

---

## TASK-002: Configure database strategy for SQLite and MySQL

Status: done

Scope:
- Configure SQLite as local/demo default.
- Document MySQL as production recommendation.
- Ensure migrations can run on SQLite.
- Add or document `database/database.sqlite` creation.

Acceptance Criteria:
- SQLite setup is documented.
- MySQL production recommendation is documented.
- No engine-specific migration exists without documentation.

Do Not:
- Do not add raw MySQL-only SQL.
- Do not use database enum columns for statuses.

---

## TASK-003: Add AdminLTE assets as UI base

Status: done

Scope:
- Add AdminLTE assets using the project’s chosen frontend asset workflow.
- Make assets available to admin layout.
- Use AdminLTE as UI only.

Acceptance Criteria:
- AdminLTE CSS/JS loads in admin layout.
- No AdminLTE architecture or sample pages are blindly copied.

Do Not:
- Do not use Filament.
- Do not copy unnecessary AdminLTE demo pages.

---

## TASK-004: Build admin layout shell

Status: done

Scope:
- Create admin layout.
- Create header/navbar partial.
- Create sidebar partial.
- Create footer partial.
- Create breadcrumb partial or component.
- Create flash message partial or component.

Suggested files:
- `resources/views/admin/layouts/app.blade.php`
- `resources/views/admin/partials/header.blade.php`
- `resources/views/admin/partials/sidebar.blade.php`
- `resources/views/admin/partials/footer.blade.php`
- `resources/views/admin/partials/breadcrumb.blade.php`
- `resources/views/admin/partials/flash.blade.php`

Acceptance Criteria:
- Admin layout renders cleanly.
- Sidebar follows the approved WordPress-like groups.
- Layout is reusable by all admin pages.

Do Not:
- Do not implement CRUD modules in this task.

---

## TASK-005: Implement admin authentication foundation

Status: done

Scope:
- Add admin login flow.
- Protect admin routes.
- Add admin middleware if needed.
- Seed default admin user.

Acceptance Criteria:
- Admin can log in.
- `/admin/dashboard` is protected.
- Default admin credentials are documented for demo only.

Do Not:
- Do not implement roles/permissions yet unless required by chosen auth flow.

---

## TASK-006: Build basic admin dashboard page

Status: done

Scope:
- Add `/admin/dashboard`.
- Use AdminLTE cards/widgets.
- Show placeholder or real basic counts if available.

Acceptance Criteria:
- Dashboard page displays inside admin layout.
- UI is clean and ready for later stats.

Do Not:
- Do not implement products/orders just to fill stats.

---

# Milestone 2: Core CMS Foundation

## TASK-007: Create reusable admin UI components

Status: done

Scope:
- Create reusable components/partials for cards, tables, badges, empty states, form fields, image upload placeholder, confirm delete, breadcrumbs, flash messages.

Acceptance Criteria:
- Components can be used by future modules.
- Repeated UI does not require duplicate markup.

Do Not:
- Do not build module-specific business logic here.

---

## TASK-008: Implement settings system foundation

Status: done

Scope:
- Add settings migration/model.
- Add setting helper/service.
- Add settings seeder for store/theme/contact/social/SEO defaults.
- Add basic admin settings UI if appropriate.

Fields concept:
- group
- key
- value
- type

Acceptance Criteria:
- `setting('key')` or equivalent works.
- Settings are seeded.
- Settings can be edited from admin or are ready for edit UI.

Do Not:
- Do not hardcode theme values in Blade.

---

## TASK-009: Implement media library foundation

Status: done

Scope:
- Add media migration/model.
- Add upload storage rules.
- Add media list page.
- Add upload/delete actions.
- Store files in public storage.

Acceptance Criteria:
- Admin can upload media.
- Uploaded media is stored and listed.
- Media records contain enough metadata for reuse.

Do Not:
- Do not tie media only to products.

---

## TASK-010: Implement roles and permissions foundation

Status: done

Scope:
- Add roles/permissions support.
- Seed Super Admin/Admin/Content Manager/Order Manager/Product Manager.
- Protect admin sections where practical.

Acceptance Criteria:
- Roles exist.
- Permissions exist.
- Admin user has super admin access.
- Existing admin modules are protected by permission middleware.

Do Not:
- Do not overcomplicate UI if backend foundation is the active goal.

---

# Milestone 3: Content Modules

## TASK-011: Implement CMS pages module

Status: done

Scope:
- Add pages migration/model/controller/routes/views.
- Fields: title, slug, content, status, SEO title, SEO description, SEO image, canonical URL, meta robots.
- Add index/create/edit/show where relevant.

Acceptance Criteria:
- Admin can create/edit/delete/list pages.
- Pages have SEO fields.
- Slug is unique.

Do Not:
- Do not hardcode static page content.

---

## TASK-012: Implement homepage sections / simple page builder

Status: done

Scope:
- Add page_sections migration/model/controller/routes/views.
- Support section types such as hero, banner, featured_products, categories_grid, text_image, testimonials, faq, cta, newsletter.
- Add sort order and active/inactive state.
- Add JSON settings field if needed.

Acceptance Criteria:
- Admin can manage homepage sections.
- Frontend can render active sections by type.
- Sections are sortable.

Do Not:
- Do not build a full Elementor-like builder.

---

## TASK-013: Implement menu builder

Status: done

Scope:
- Add menus and menu_items migrations/models.
- Support Header Menu, Footer Menu, Mobile Menu.
- Menu item types: page, category, product, custom URL.
- Add sort order and nesting if simple enough.

Acceptance Criteria:
- Admin can manage menus.
- Frontend navigation is database-driven.

Do Not:
- Do not hardcode header/footer nav links.

---

## TASK-014: Implement frontend theme structure

Status: done

Scope:
- Create frontend/storefront layout.
- Create theme-friendly folder structure.
- Add home, shop, product details, category, cart, checkout, order success, contact, static page templates.

Acceptance Criteria:
- Frontend uses a clear theme structure.
- Pages can later be customized without touching admin.

Do Not:
- Do not fill pages with hardcoded final content.

---

# Milestone 4: Catalog Modules

## TASK-015: Implement categories module

Status: done

Scope:
- Add categories migration/model/controller/routes/views.
- Fields: name, slug, image, parent category, description, status, sort order, SEO fields.

Acceptance Criteria:
- Admin can create/edit/delete/list categories.
- Categories support image and SEO.
- Categories can be used in frontend and products.

Do Not:
- Do not hardcode category navigation.

---

## TASK-016: Implement products module

Status: done

Scope:
- Add products migration/model/controller/routes/views.
- Fields: name, slug, description, short description, price, sale price, SKU, stock quantity, status, category, featured, SEO fields.
- Add product image support through media or product images table.

Acceptance Criteria:
- Admin can manage products.
- Products have images, pricing, inventory, category, status, SEO.
- Product list has search/filter/pagination.

Do Not:
- Do not implement checkout here.

---

## TASK-017: Implement catalog frontend pages

Status: done

Scope:
- Shop page.
- Category products page.
- Product details page.
- Use seeded/products/categories data.

Acceptance Criteria:
- Customers can browse shop/category/product pages.
- Frontend reads products/categories from DB.

Do Not:
- Do not hardcode product cards.

---

# Milestone 5: Sales Flow

## TASK-018: Implement cart

Status: done

Scope:
- Add add-to-cart.
- Remove from cart.
- Update quantity.
- Cart summary.
- Use session-based cart for MVP unless spec changes.

Acceptance Criteria:
- Customer can add/update/remove products in cart.
- Cart totals are calculated correctly for MVP.

Do Not:
- Do not implement payment integrations here.

---

## TASK-019: Implement checkout and order creation

Status: done

Scope:
- Add checkout form.
- Fields: customer name, email, phone, address, notes.
- Create order and order_items.
- Add order success page.

Acceptance Criteria:
- Customer can place a basic order.
- Order and order items are stored.
- Cart clears after successful order.

Do Not:
- Do not add real payment gateway.

---

## TASK-020: Implement orders management

Status: done

Scope:
- Add admin orders list/details.
- Show customer info, order items, totals, status, timeline/notes.
- Allow status update: pending, processing, completed, cancelled, refunded.

Acceptance Criteria:
- Admin can view and update orders.
- Order details page is clear and polished.

Do Not:
- Do not implement complex fulfillment integrations.

---

## TASK-021: Implement customer management

Status: done

Scope:
- Add customers list/details.
- Show customer orders and addresses where available.
- Support guest checkout data as stored customer records or equivalent.

Acceptance Criteria:
- Admin can view customers.
- Admin can see customer order history.

Do Not:
- Do not build CRM features.

---

## TASK-022: Implement shipping/payment/tax settings foundation

Status: done

Scope:
- Add basic settings pages/fields for cash on delivery, flat shipping rate, free shipping threshold, tax percentage.

Acceptance Criteria:
- Checkout can use basic shipping/tax settings.
- Settings are editable.

Do Not:
- Do not add payment gateway integrations.

---

# Milestone 6: Demo Experience

## TASK-023: Add demo media assets and seeder

Status: done

Scope:
- Add demo media storage strategy.
- Add seeder that copies or registers demo logo, favicon, hero, banners, category images, product images.
- Add credits file if using external free media.

Acceptance Criteria:
- Demo media appears after seed.
- Media is replaceable from admin.
- No main media path is hardcoded in Blade.

Do Not:
- Do not depend on remote image URLs at runtime.

---

## TASK-024: Add full demo data seeders

Status: done

Scope:
- Seed settings, menus, pages, sections, categories, products, customers, orders, email templates, SEO defaults.

Acceptance Criteria:
- `php artisan migrate:fresh --seed` creates a polished demo store.
- Admin dashboard and storefront do not look empty.

Do Not:
- Do not seed data that cannot be edited later.

---

## TASK-025: Polish demo frontend homepage

Status: done

Scope:
- Render homepage sections.
- Show hero, banners, categories, featured products, offers, testimonials, newsletter.

Acceptance Criteria:
- Home page looks like a real demo store.
- Content comes from database-backed sections/settings.

Do Not:
- Do not hardcode section content.

---

# Milestone 7: Admin Polish and Starter Kit Readiness

## TASK-026: Implement SEO system rendering

Status: done

Scope:
- Render page/product/category SEO fields in frontend meta tags.
- Add default SEO fallback settings.

Acceptance Criteria:
- SEO title/description/image render correctly.
- Defaults are used when model-specific SEO is missing.

Do Not:
- Do not add advanced SEO automation outside scope.

---

## TASK-027: Implement email templates and notifications foundation

Status: done

Scope:
- Add email templates for order placed, order status changed, password reset/contact if applicable.
- Store template content in DB/settings where practical.

Acceptance Criteria:
- Basic email templates exist.
- Order-related notification foundation is ready.

Do Not:
- Do not add third-party email marketing tools.

---

## TASK-028: Implement activity logs

Status: done

Scope:
- Log important admin actions: product updates, order status changes, settings updates, page updates.
- Add activity logs admin page.

Acceptance Criteria:
- Admin actions are logged.
- Logs can be viewed in admin.

Do Not:
- Do not log sensitive data unnecessarily.

---

## TASK-029: Implement export preparation

Status: done

Scope:
- Add CSV export for products, orders, and customers if feasible.
- Otherwise add service structure/placeholders documented for later export.

Acceptance Criteria:
- Export feature or prepared structure exists.
- Admin can access exports if implemented.

Do Not:
- Do not build full backup system unless explicitly requested.

---

## TASK-030: Implement empty/error/confirmation states

Status: done

Scope:
- Audit admin pages.
- Add empty states, error states, confirmation modals/forms, and flash messages.

Acceptance Criteria:
- No module list looks broken when empty.
- Destructive actions require confirmation.
- CRUD actions show success/error messages.

Do Not:
- Do not redesign unrelated screens.

---

## TASK-031: Implement system/maintenance page

Status: done

Scope:
- Add basic system page showing app version/environment/storage link status.
- Add clear cache action only if safe.

Acceptance Criteria:
- Admin has a simple maintenance/system page.

Do Not:
- Do not expose dangerous server controls.

---

## TASK-032: Add installation command or final setup documentation

Status: done

Scope:
- Add `php artisan app:install` if appropriate, or improve README setup flow.
- Document SQLite demo setup and MySQL production setup.
- Document default admin login.

Acceptance Criteria:
- New developer can install and seed project by following README.
- Starter kit usage is clear.

Do Not:
- Do not require manual hidden steps.

---

## TASK-033: Final verification pass

Status: done

Scope:
- Verify migrations/seeders.
- Verify admin login/dashboard.
- Verify frontend demo flow.
- Verify cart/checkout/order creation.
- Verify editable content rules.
- Verify no Filament usage.

Acceptance Criteria:
- Project satisfies the main spec.
- Known limitations are documented.

Do Not:
- Do not add new features during final verification.

---

# Post-MVP Professional Store Roadmap

These tasks are for turning the starter kit from a strong MVP into a more production-ready professional store.
Implement one task only at a time.

## TASK-034: Implement payment status foundation

Status: pending

Scope:
- Add payment status fields to existing order/payment flow.
- Track statuses such as unpaid, paid, failed, refunded.
- Keep Cash on Delivery compatible.
- Prepare the order model/admin order details for payment status display.

Acceptance Criteria:
- Orders can store payment status separately from order status.
- Admin can see payment status on order list/details.
- Existing checkout still works.

Do Not:
- Do not integrate a real payment gateway in this task.
- Do not remove Cash on Delivery.

---

## TASK-035: Implement payment gateway integration foundation

Status: pending

Scope:
- Add a Laravel-native payment gateway abstraction/service.
- Add configuration settings for one selected gateway.
- Add payment initiation and callback/webhook placeholders.
- Keep implementation gateway-specific but isolated.

Acceptance Criteria:
- Checkout can hand off to a configured payment service.
- Webhook/callback route can update payment status safely.
- Failed payment can be handled without creating inconsistent orders.

Do Not:
- Do not add multiple gateways at once.
- Do not store sensitive card data.

---

## TASK-036: Implement shipping zones and rates

Status: pending

Scope:
- Add shipping zones/locations and rates.
- Support flat rates by zone.
- Allow checkout to calculate shipping from selected zone.
- Add admin management for shipping zones/rates.

Acceptance Criteria:
- Admin can manage shipping zones and rates.
- Checkout uses configured shipping rates.
- Existing basic shipping settings remain compatible or are migrated cleanly.

Do Not:
- Do not integrate external shipping carriers yet.
- Do not add database-specific SQL.

---

## TASK-037: Implement coupons and discounts

Status: done

Scope:
- Add coupons module.
- Support fixed amount and percentage discounts.
- Support active dates, usage limits, minimum order amount, and status.
- Apply coupon discounts in cart/checkout.

Acceptance Criteria:
- Admin can create/edit/delete coupons.
- Customer can apply a valid coupon.
- Invalid/expired coupons show clear errors.
- Order stores applied discount details.

Do Not:
- Do not add gift cards or loyalty points.
- Do not add overly complex promotion rules.

---

## TASK-038: Implement inventory management foundation

Status: pending

Scope:
- Track inventory changes for products.
- Decrease stock when an order is placed.
- Restore stock when an order is cancelled/refunded where appropriate.
- Add low stock indicators/report.

Acceptance Criteria:
- Stock cannot silently go negative.
- Admin can see low stock products.
- Order status changes keep stock consistent.

Do Not:
- Do not implement warehouse/location inventory yet.
- Do not implement supplier purchase orders.

---

## TASK-039: Implement product attributes and variants

Status: pending

Scope:
- Add attributes such as size/color/material.
- Add product variants with SKU, price, sale price, stock, status, and image if practical.
- Update admin product management for variants.
- Update storefront product details to select variants.

Acceptance Criteria:
- Admin can manage attributes and variants.
- Customer can select a variant before adding to cart.
- Cart and orders store selected variant data.

Do Not:
- Do not break simple products.
- Do not implement advanced product bundles.

---

## TASK-040: Implement customer accounts and My Account area

Status: pending

Scope:
- Add customer registration/login/logout.
- Add My Account dashboard.
- Show customer order history.
- Allow customers to manage saved addresses.

Acceptance Criteria:
- Customers can create accounts and log in.
- Logged-in customers can view their orders.
- Guest checkout remains available unless explicitly disabled.

Do Not:
- Do not build CRM automation.
- Do not merge admin auth with customer auth.

---

## TASK-041: Improve order lifecycle, invoices, and fulfillment

Status: pending

Scope:
- Add order status history records.
- Add invoice/print-friendly order view.
- Add fulfillment/shipping status fields if needed.
- Improve admin order notes/timeline.

Acceptance Criteria:
- Admin can see a reliable timeline of order changes.
- Orders can be printed or exported as invoice-style pages.
- Fulfillment status is separate from payment status where appropriate.

Do Not:
- Do not add carrier integrations yet.
- Do not add accounting integrations.

---

## TASK-042: Expand email notifications and template management

Status: pending

Scope:
- Add admin edit UI for email templates.
- Add preview support for templates.
- Send order placed/status/payment emails where appropriate.
- Support queued emails using Laravel queues.

Acceptance Criteria:
- Admin can edit email templates.
- Emails are sent for key order events.
- Templates can be previewed before saving.

Do Not:
- Do not add third-party email marketing tools.
- Do not hardcode email content in code.

---

## TASK-043: Implement storefront search, filters, and sorting

Status: pending

Scope:
- Add product search.
- Add category, price, stock/status, and sale filters where practical.
- Add sorting by latest, price, and name.
- Keep filters SQLite-compatible.

Acceptance Criteria:
- Customers can search and filter products on shop/category pages.
- Filter URLs are shareable.
- Empty results show clear empty states.

Do Not:
- Do not add external search services.
- Do not use database-specific full-text search.

---

## TASK-044: Implement product reviews and ratings

Status: pending

Scope:
- Add product reviews and ratings.
- Add admin moderation for reviews.
- Show approved reviews and average rating on storefront product pages.

Acceptance Criteria:
- Customers can submit reviews.
- Admin can approve/reject reviews.
- Product pages show approved reviews only.

Do Not:
- Do not add third-party review platforms.
- Do not allow unmoderated spam-prone reviews.

---

## TASK-045: Implement wishlist foundation

Status: pending

Scope:
- Add customer/session wishlist foundation.
- Allow adding/removing products from wishlist.
- Add wishlist storefront page.

Acceptance Criteria:
- Customers can save products to a wishlist.
- Wishlist persists for logged-in customers or session users as scoped.
- Products can be moved from wishlist to cart.

Do Not:
- Do not implement product comparison in this task.
- Do not require customer accounts if session wishlist is chosen first.

---

## TASK-046: Implement advanced SEO outputs

Status: pending

Scope:
- Add XML sitemap generation.
- Add robots.txt output.
- Add product/category/page structured data where practical.
- Add breadcrumb structured data if breadcrumbs exist.

Acceptance Criteria:
- Sitemap includes published pages/categories/products.
- Robots output is configurable or safe by default.
- Product pages include valid structured data.

Do Not:
- Do not add paid SEO services.
- Do not hardcode SEO content in Blade.

---

## TASK-047: Implement admin users, roles, and permissions UI

Status: pending

Scope:
- Add admin UI for admin users.
- Add admin UI for roles and permissions.
- Allow assigning roles to admin users.
- Keep Super Admin access intact.

Acceptance Criteria:
- Super Admin can manage admin users and roles.
- Permissions can be reviewed from the admin panel.
- Existing permission middleware behavior remains intact.

Do Not:
- Do not replace the existing custom permission foundation.
- Do not install Spatie unless explicitly approved later.

---

## TASK-048: Implement reports and analytics pages

Status: pending

Scope:
- Add basic admin reports for sales, orders, products, customers, and inventory.
- Support date range filters.
- Add simple dependency-free summaries/tables.

Acceptance Criteria:
- Admin can review sales by date range.
- Admin can see top products and recent customer/order activity.
- Reports remain SQLite-compatible.

Do Not:
- Do not add heavy charting libraries unless explicitly requested.
- Do not add external analytics services.

---

## TASK-049: Improve production readiness

Status: pending

Scope:
- Document queue worker setup.
- Document cache/config/view optimization commands.
- Add backup strategy documentation or safe backup foundation.
- Add production security checklist.
- Add monitoring/logging recommendations.

Acceptance Criteria:
- README or production docs explain deployment readiness.
- Production checklist covers env, queues, cache, storage, backups, and logs.
- No unsafe destructive maintenance actions are exposed.

Do Not:
- Do not implement server management UI.
- Do not require a specific hosting provider.
