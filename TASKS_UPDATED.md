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

Status: done

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

Status: done

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

Status: done

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

Status: done

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

Status: completed

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

Status: completed

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

Status: completed

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

Status: completed

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

Status: completed

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

---

# Updated Completion Roadmap: Production Store + Storefront Polish

This section was added after the MVP verification pass to capture:

- Pending items from the original Post-MVP roadmap.
- Storefront/frontend improvements required because the current frontend is functional but visually light.
- Extra launch-readiness tasks needed to turn the starter kit into a sellable, production-ready product.

## Current Completion Snapshot

Completed:
- `TASK-001` through `TASK-033` are complete.
- `TASK-037` coupons and discounts is complete.

Still pending from the older roadmap:
- `TASK-034` Payment status foundation.
- `TASK-035` Payment gateway integration foundation.
- `TASK-036` Shipping zones and rates.
- `TASK-038` Inventory management foundation.
- `TASK-039` Product attributes and variants.
- `TASK-040` Customer accounts and My Account area.
- `TASK-041` Order lifecycle, invoices, and fulfillment.
- `TASK-042` Expanded email notifications and template management.
- `TASK-043` Storefront search, filters, and sorting.
- `TASK-044` Product reviews and ratings.
- `TASK-045` Wishlist foundation.
- `TASK-046` Advanced SEO outputs.
- `TASK-047` Admin users, roles, and permissions UI.
- `TASK-048` Reports and analytics pages.
- `TASK-049` Production readiness.

Recommended build order:
1. Storefront visual polish and demo content: `TASK-050` to `TASK-059`.
2. Core production commerce: `TASK-034`, `TASK-035`, `TASK-036`, `TASK-038`, `TASK-040`, `TASK-041`, `TASK-042`, `TASK-043`, `TASK-049`.
3. Professional add-ons: `TASK-039`, `TASK-044`, `TASK-045`, `TASK-046`, `TASK-047`, `TASK-048`.
4. Final launch checks: `TASK-060` to `TASK-064`.

---

# Milestone 8: Storefront Experience and Theme Polish

These tasks turn the functional storefront into a commercial, polished ecommerce theme. The goal is to make a fresh seeded install look like a real store, not just a technical demo.

## TASK-050: Build storefront design system

Status: completed

Scope:
- Create reusable storefront Blade components.
- Standardize buttons, cards, badges, prices, breadcrumbs, section headers, empty states, alerts, pagination, and form controls.
- Add consistent spacing, typography, border radius, shadows, and responsive container rules.
- Keep components compatible with the existing Blade/theme structure.

Suggested files:
- `resources/views/storefront/components/product-card.blade.php`
- `resources/views/storefront/components/category-card.blade.php`
- `resources/views/storefront/components/section-heading.blade.php`
- `resources/views/storefront/components/price.blade.php`
- `resources/views/storefront/components/badge.blade.php`
- `resources/views/storefront/components/breadcrumb.blade.php`
- `resources/views/storefront/components/empty-state.blade.php`
- `resources/views/storefront/components/promo-banner.blade.php`
- `resources/views/storefront/components/trust-badges.blade.php`

Acceptance Criteria:
- Repeated storefront UI uses shared components.
- Product/category cards look consistent across home, shop, category, related products, and wishlist areas.
- Empty states and alerts do not look broken or unfinished.
- Components are responsive and do not require duplicated markup.

Do Not:
- Do not hardcode product/category/demo data inside components.
- Do not redesign the admin panel in this task.
- Do not add heavy frontend frameworks unless explicitly approved.

---

## TASK-051: Redesign homepage into a commercial landing page

Status: pending

Scope:
- Improve the homepage using existing `page_sections`, settings, media, categories, products, and coupons.
- Add/upgrade sections: hero, trust badges, visual categories, featured products, new arrivals, best sellers, sale/offers, promo banners, testimonials, FAQ teaser, newsletter, and CTA blocks.
- Add fallback rendering for missing section content so the homepage never looks empty.
- Ensure all homepage content remains database-backed and editable.

Acceptance Criteria:
- Homepage looks like a real ecommerce demo immediately after seed.
- Hero, banners, categories, products, offers, testimonials, and newsletter render cleanly.
- Homepage works well on desktop, tablet, and mobile.
- No final homepage copy or navigation is hardcoded in Blade.

Do Not:
- Do not build a full page builder.
- Do not depend on remote images at runtime.
- Do not remove the existing page section foundation.

---

## TASK-052: Redesign shop and category listing pages

Status: pending

Scope:
- Improve shop and category page layouts.
- Add visual filter UI, sort dropdown, product count, active filter chips, category intro area, grid/list-ready structure, and polished pagination.
- Add responsive mobile filter drawer or collapsible filters.
- Improve no-results and empty category states.
- Prepare UI for `TASK-043` search, filters, and sorting if backend is not implemented yet.

Acceptance Criteria:
- Shop/category pages feel complete with both small and medium catalogs.
- Customers can clearly understand where they are, how many products exist, and how to browse.
- Mobile filter/sort experience is clean.
- Empty results show helpful recovery actions.

Do Not:
- Do not add external search services.
- Do not use database-specific full-text search.
- Do not hardcode category/product cards.

---

## TASK-053: Redesign product details page for conversion

Status: pending

Scope:
- Improve product details page layout.
- Add image gallery with thumbnails, sale/new/out-of-stock badges, price block, SKU, stock status, short description, quantity selector, and clear add-to-cart area.
- Add trust box for shipping, returns, support, and payment reassurance.
- Add accordion or section-based content for description, specifications, shipping/returns, and reviews placeholder.
- Add related products and recently viewed placeholder if feasible.
- Add sticky mobile add-to-cart bar where appropriate.

Acceptance Criteria:
- Product page clearly supports purchase decisions.
- Product images, price, stock, and CTA are prominent.
- Product page works well on mobile.
- Related products render from existing DB data.

Do Not:
- Do not implement variants in this task unless `TASK-039` is explicitly active.
- Do not implement real reviews in this task unless `TASK-044` is explicitly active.
- Do not hardcode product details.

---

## TASK-054: Redesign cart, checkout, and order success UX

Status: pending

Scope:
- Improve cart page product rows, quantity controls, remove actions, coupon UI, cart totals, shipping/tax summary, and checkout CTA.
- Improve checkout form layout, validation states, payment method display, order summary, coupon display, and place-order button.
- Improve order success page with order number, customer summary, next steps, and continue-shopping CTA.
- Ensure existing cart, coupon, shipping, tax, and order creation logic still works.

Acceptance Criteria:
- Cart and checkout feel trustworthy and production-ready.
- Coupon, shipping, tax, discount, and total calculations are visually clear.
- Validation errors are easy to understand.
- Order success page does not feel empty.

Do Not:
- Do not add a real payment gateway in this task.
- Do not change order calculation rules unless required by an existing implemented feature.
- Do not remove guest checkout.

---

## TASK-055: Expand demo storefront content and seed data

Status: pending

Scope:
- Expand demo products, categories, product images, category images, banners, homepage sections, testimonials, FAQs, pages, menu links, and footer content.
- Add enough sample data so the frontend does not look empty after `php artisan migrate:fresh --seed`.
- Add realistic demo copy for ecommerce pages and policies.
- Keep all demo content editable from admin modules.

Acceptance Criteria:
- Fresh seeded install looks rich and sellable.
- Home, shop, category, product, cart, checkout, static pages, and footer have realistic content.
- Demo media is local or bundled and does not rely on remote runtime URLs.
- No seeded content is locked into Blade templates.

Do Not:
- Do not use copyrighted media without credits/permission.
- Do not seed data that cannot be edited later.
- Do not make seeders slow or fragile.

---

## TASK-056: Add responsive polish and storefront microinteractions

Status: pending

Scope:
- Audit storefront responsive behavior across common breakpoints.
- Add hover states, focus states, transition polish, loading states, image fallbacks, skeleton placeholders where useful, and better mobile spacing.
- Improve mobile header, cart icon, menu behavior, product grid spacing, and checkout field layout.
- Add accessible focus-visible styles for keyboard users.

Acceptance Criteria:
- Storefront feels modern and intentional.
- Mobile browsing and checkout are comfortable.
- Images do not stretch, jump, or break layouts.
- Interactive elements provide clear visual feedback.

Do Not:
- Do not introduce large JavaScript dependencies for simple interactions.
- Do not change backend behavior in this task.
- Do not hide accessibility outlines without replacing them with visible focus styles.

---

## TASK-057: Improve storefront header, footer, and navigation UX

Status: pending

Scope:
- Improve header layout, logo handling, cart count, account links placeholder, search entry point, mobile menu, and sticky behavior if appropriate.
- Improve footer with menu groups, contact info, social links, newsletter block, payment/shipping trust indicators, and policy links.
- Ensure navigation remains database-driven through menus/settings.
- Add optional mega-menu-ready structure without implementing a complex mega menu.

Acceptance Criteria:
- Header and footer feel complete and commercial.
- Mobile navigation is clear and easy to use.
- Cart count and main CTAs are visible.
- Header/footer content is editable through existing settings/menus where practical.

Do Not:
- Do not hardcode final navigation links.
- Do not implement customer accounts here unless `TASK-040` is active.
- Do not add complex menu-builder logic unless separately scoped.

---

## TASK-058: Add storefront trust and policy pages using CMS

Status: pending

Scope:
- Add or improve CMS-backed pages for About, Contact, FAQ, Shipping Policy, Return Policy, Privacy Policy, Terms and Conditions, and Payment Methods.
- Ensure footer and checkout can link to trust/policy pages.
- Add simple contact information blocks from settings.
- Add FAQ sections where useful.

Acceptance Criteria:
- Storefront has the core trust pages expected from a real ecommerce store.
- Pages are editable from the CMS pages module.
- Footer, product page, cart, and checkout can reference policy links cleanly.

Do Not:
- Do not hardcode legal text directly in Blade.
- Do not claim legal compliance guarantees.
- Do not build a support ticket system in this task.

---

## TASK-059: Storefront performance and image optimization pass

Status: pending

Scope:
- Add frontend performance polish for storefront pages.
- Use lazy loading for non-critical images.
- Ensure product/category/media images have width/height or aspect-ratio handling.
- Add sensible image fallbacks.
- Review Vite/CSS/JS asset usage and remove unused storefront bloat where safe.
- Add documentation for recommended image sizes.

Acceptance Criteria:
- Storefront pages load cleanly with stable layouts.
- Product/category cards do not cause layout shift.
- Missing images degrade gracefully.
- Storefront asset strategy is documented.

Do Not:
- Do not build a full CDN integration.
- Do not introduce server-level image processing unless explicitly approved.
- Do not remove AdminLTE admin assets by mistake.

---

# Milestone 9: Production Commerce Completion

This milestone tracks the most important pending backend/product features from the older roadmap. These tasks already exist above, but this section defines the recommended production priority and dependencies.

## Production Priority Group A: Must-have before real launch

Recommended tasks:
- `TASK-034` Payment status foundation.
- `TASK-035` Payment gateway integration foundation.
- `TASK-036` Shipping zones and rates.
- `TASK-038` Inventory management foundation.
- `TASK-040` Customer accounts and My Account area.
- `TASK-041` Order lifecycle, invoices, and fulfillment.
- `TASK-042` Expanded email notifications and template management.
- `TASK-043` Storefront search, filters, and sorting.
- `TASK-049` Production readiness.

Launch Gate Criteria:
- Orders have separate order, payment, fulfillment, and inventory behavior where appropriate.
- Checkout can complete safely without inconsistent stock/payment/order states.
- Customers can track or review their orders through account or email flows.
- Admin can operate orders without manual database edits.
- Deployment, queues, backups, cache, logs, storage, and security are documented.

---

## Production Priority Group B: Professional store add-ons

Recommended tasks:
- `TASK-039` Product attributes and variants.
- `TASK-044` Product reviews and ratings.
- `TASK-045` Wishlist foundation.
- `TASK-046` Advanced SEO outputs.
- `TASK-047` Admin users, roles, and permissions UI.
- `TASK-048` Reports and analytics pages.

Launch Gate Criteria:
- These are not all required for the first launch, but they make the product significantly more competitive as a reusable ecommerce CMS.
- Variants should be prioritized earlier if the target demo niche includes fashion, shoes, accessories, electronics specs, or configurable products.
- Reviews and wishlist can follow after checkout, payment, shipping, and inventory are stable.

---

# Milestone 10: Final QA, Hardening, and Product Packaging

## TASK-060: Run full storefront UX QA pass

Status: pending

Scope:
- Test the complete customer journey: home, menu, search/browse, category, product, cart, coupon, checkout, order success, email, and account where available.
- Test empty states, invalid coupon, out-of-stock product, missing image, disabled product, inactive category, and checkout validation errors.
- Test desktop, tablet, and mobile layouts.

Acceptance Criteria:
- Main customer flows work without visual or functional blockers.
- Edge cases have clear messages.
- Storefront does not show broken layouts with small or large demo data sets.

Do Not:
- Do not add new features during QA unless a blocker requires a minimal fix.
- Do not skip mobile testing.

---

## TASK-061: Run accessibility and basic UX audit

Status: pending

Scope:
- Review semantic headings, labels, form errors, color contrast, focus states, keyboard navigation, image alt text, and button/link clarity.
- Improve accessible names for cart, menu, search, filters, quantity controls, and destructive actions.
- Ensure validation errors are visible and associated with fields.

Acceptance Criteria:
- Core storefront and admin flows are keyboard-friendly.
- Forms have labels and clear errors.
- Images and buttons have meaningful accessible text where needed.
- Focus states are visible.

Do Not:
- Do not claim formal WCAG certification.
- Do not remove visual focus styles.

---

## TASK-062: Run security and data-safety hardening pass

Status: pending

Scope:
- Review authorization checks for admin routes and destructive actions.
- Review validation for uploads, checkout forms, settings, coupons, products, categories, pages, and orders.
- Confirm sensitive data is not logged in activity logs.
- Confirm CSRF protection on forms.
- Confirm public/private storage boundaries.
- Add security notes to production docs where useful.

Acceptance Criteria:
- Admin-only actions are permission-protected.
- Uploads are constrained by type/size.
- Sensitive customer/payment data is not unnecessarily stored or logged.
- Forms use validation and CSRF protection.

Do Not:
- Do not store card data.
- Do not expose unsafe maintenance actions.
- Do not weaken middleware to fix UI issues.

---

## TASK-063: Add launch checklist and deployment runbook

Status: pending

Scope:
- Add a concise launch checklist to README or production docs.
- Include environment variables, app key, database, storage link, queues, scheduler, cache/config/view optimization, email config, payment webhook URLs, backups, logs, and admin credentials reset.
- Include SQLite demo notes and MySQL/PostgreSQL-style production recommendations where applicable.
- Include post-deploy smoke test steps.

Acceptance Criteria:
- A new developer/operator can deploy and verify the project using documented steps.
- Checklist covers common launch failures.
- Demo credentials are clearly marked as demo-only.

Do Not:
- Do not require a specific hosting provider.
- Do not include real secrets.
- Do not document unsafe production defaults.

---

## TASK-064: Package starter kit for reuse/sale

Status: pending

Scope:
- Clean README, screenshots, demo credentials, feature list, installation steps, known limitations, roadmap, and licensing notes.
- Add screenshots or placeholder paths for admin dashboard, homepage, shop, product, cart, checkout, and order management.
- Add a clear “what is included” and “what is not included” section.
- Add changelog or release notes structure.

Acceptance Criteria:
- The project can be presented as a polished ecommerce CMS starter kit.
- Buyers/developers can understand features, setup, limitations, and roadmap quickly.
- Documentation matches implemented behavior.

Do Not:
- Do not overpromise unsupported production features.
- Do not include paid assets without license notes.
- Do not remove technical setup details.

---

## TASK-055: Visual Content Scheme & Integration

Status: in_progress

### TASK-055A: Define storefront visual content schema
Status: done

Scope:
- Create database migration for image IDs on products, variants, categories, and page sections.
- Update model relationships and fillable properties.
- Add default store image settings to SettingSeeder.

### TASK-055B: Build admin UI for visual content management
Status: done

Scope:
- Added media-select partial component for reusable ID-based image selection.
- Added main_image_id, hover_image_id, seo_image_id selects to product form.
- Added cover_image_id, icon_image_id selects to category form.
- Added desktop_image_id, mobile_image_id, background_image_id, image_alt, image_position, overlay_style fields to section form.
- Added image_id select to product variant form.
- Updated ProductController, CategoryController, SectionController, ProductVariantController with mediaOptions and validation.

### TASK-055C: Add premium demo media and content seeders
Status: done

Scope:
- Created local demo SVG assets: hero-desktop.svg, hero-mobile.svg, banner-bg.svg, product-backpack-hover.svg, product-lamp-hover.svg, product-sneakers-hover.svg.
- Built idempotent DemoMediaSeeder registering 15 Media records from demo/ assets.
- Assigned main_image_id, hover_image_id, seo_image_id to all 3 demo products.
- Assigned cover_image_id, icon_image_id to Fashion and Home categories.
- Assigned desktop_image_id, mobile_image_id, image_alt, image_position, overlay_style to hero section.
- Assigned desktop_image_id, background_image_id, image_alt, image_position, overlay_style to banner section.
- Seeded store.default_product_image, store.default_category_image, store.default_hero_image, store.default_og_image settings.

### TASK-055D: Update storefront image rendering rules
Status: done

Scope:
- Updated HomeController: eager-loads desktopImage, mobileImage, backgroundImage on sections; coverImage on categories; mainImage, hoverImage on featuredProducts.
- Updated CatalogController: productQuery eager-loads mainImage, hoverImage; product detail loads mainImage, hoverImage; publishedCategories eager-loads coverImage.
- Updated product-card.blade.php: mainImage → primaryImage → default_product_image → neutral fallback; optional hover image swap.
- Updated category-card.blade.php: coverImage → legacy image → default_category_image → dark fallback.
- Updated hero.blade.php: desktopImage → mobileImage → legacy image → default_hero_image; respects image_alt, image_position, overlay_style.
- Updated banner.blade.php: backgroundImage → desktopImage → legacy image; respects image_alt, image_position, overlay_style.
- Updated product-details.blade.php: mainImage (Media) shown first, then gallery images (legacy ProductImage), then hoverImage if no gallery, then neutral fallback.
