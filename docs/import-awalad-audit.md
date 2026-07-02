# Awalad Farouk Store Import Audit

## Source Project Summary
- **Path:** `C:\xampp\htdocs\awalad-farouk`
- **Framework:** Laravel (using SQLite)
- **E-commerce Features:** Products, Categories, Variations, Product Images, Orders, Customers, Historical Orders, Advanced Shipping (Governorates/Areas), Settings.
- **Missing Features (compared to new CMS):** The old project lacks a database-driven `PageSection` CMS for the homepage. It seems to have relied on hardcoded views or static templates for about/contact pages and the homepage.

## Source Database & Tables Summary
The following models exist in the source project:
- `Product`, `ProductCategory`, `ProductVariation`, `ProductImage`
- `Order`, `OrderItem`, `HistoricalOrder`, `HistoricalOrderItem`
- `Customer`, `User`
- `ShippingGovernorate`, `ShippingArea`
- `StoreSetting`, `Redirect`, `ImportBatch`, `ImportError`

## Source Media & Assets Summary
- Media appears to be stored under `public/imported/products`.
- No advanced media library exists in the old project (just `ProductImage` model attached to products).

## Proposed Data Mapping Table

| Old Project (Awalad Farouk) | New CMS (Starter Kit) | Notes |
|-----------------------------|-----------------------|-------|
| `ProductCategory` | `Category` | Direct mapping. Needs `cover_image_id`. |
| `Product` | `Product` | Direct mapping. Needs `main_image_id`. |
| `ProductVariation` | `ProductVariant` | Direct mapping. |
| `ProductImage` | `Media` | Migrate paths to Media, then attach. |
| `StoreSetting` | `Setting` | Migrate keys where applicable. |
| `Customer` | `Customer` | Direct mapping. |
| `Order`, `OrderItem` | `Order`, `OrderItem` | Direct mapping. |
| `HistoricalOrder` | (None) | Need to decide if these should be imported as regular Orders or ignored. |
| `ShippingGovernorate` | `ShippingZone`/`Rate` | Convert to new simplified zone/rate structure. |

## Import Phases Priority
1. **Phase 1:** Store identity, logo, settings. (Pages/menus will need to be created manually as they don't exist in the old DB).
2. **Phase 2:** Categories, Products, Variations, Media (copy images to `storage/app/public/imported/awalad`, create `Media` records, assign IDs).
3. **Phase 3:** Homepage sections/banners (Manual recreation using the new PageSection CMS).
4. **Phase 4:** Customers & Orders (Only if explicitly approved, taking care of passwords/privacy).

## Risks & Concerns
- **Missing Images:** Old paths in `public/imported/products` might not exist or might need re-linking.
- **Incompatible Schemas:** Shipping rates and historical orders have a different structure in the new CMS.
- **Duplicate Slugs:** Need to handle slug collisions during import.
- **Passwords & Privacy:** Customer passwords might use an older hash or need reset flows.

## Recommended Import Approach
1. Do a **dry-run** import command first.
2. Ensure the import is non-destructive (`updateOrCreate` by stable keys like `sku` or `slug`).
3. Copy physical files into `storage/app/public/imported/awalad`.
4. Create `Media` records for each file.
5. Assign media IDs to products and categories.
