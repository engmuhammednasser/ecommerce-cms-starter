# Laravel E-commerce CMS Starter Kit Specification

## 1. فكرة المشروع

المشروع عبارة عن **Laravel E-commerce CMS Starter Kit** قابل لإعادة الاستخدام في مشاريع المتاجر الإلكترونية، بحيث لا يتم بناء login، dashboard، CMS، المنتجات، الطلبات، الصفحات، والإعدادات من الصفر في كل مشروع جديد.

الهدف هو بناء نظام قريب في التنظيم وتجربة الإدارة من WordPress، لكن مبني بالكامل على Laravel Custom Architecture، مع استخدام AdminLTE كواجهة UI فقط.

---

## 2. القرارات المثبتة

### 2.1 Admin Dashboard

سيتم استخدام:

```txt
AdminLTE
```

لكن فقط كـ UI/Admin Template.

AdminLTE سيتم استخدامه في:

- Layout
- Sidebar
- Navbar
- Cards
- Tables
- Forms
- Badges
- Modals
- Alerts
- Dashboard widgets

AdminLTE **لن يفرض** طريقة تنظيم المشروع أو الـ architecture.

### 2.2 ممنوع استخدام Filament

لن يتم استخدام Filament كـ admin panel، لأن المطلوب dashboard أكثر مرونة وتنظيمها قريب من WordPress، وليست CRUD resources فقط.

### 2.3 نوع الداش بورد المطلوب

المطلوب بناء:

```txt
Custom Laravel Admin CMS
+ AdminLTE UI
+ WordPress-like sidebar organization
+ Custom modules
+ Editable content
+ Demo-ready store
```


### 2.4 Database Strategy

المشروع يجب أن يدعم نوعين من قواعد البيانات:

```txt
Local Development / Demo / Quick Preview  = SQLite
Staging / Real Projects / Production      = MySQL
```

القرار المثبت:

- SQLite هو الاختيار الافتراضي للتجربة السريعة وتشغيل الديمو محليًا.
- MySQL هو الاختيار الموصى به للمتاجر الحقيقية وبيئات staging وproduction.
- كل migrations وseeders يجب أن تعمل على SQLite وMySQL قدر الإمكان.
- لا يجوز بناء المشروع بطريقة تعتمد على نوع database واحد فقط.

يجب أن يكون ملف `.env.example` مناسبًا للتشغيل السريع باستخدام SQLite، مع توثيق طريقة التحويل إلى MySQL في README.

---

## 3. الهدف النهائي

بعد تشغيل المشروع لأول مرة يجب أن يكون الناتج:

- متجر تجريبي كامل الشكل وليس مشروعًا فارغًا.
- Dashboard مرتبة وواضحة.
- Demo products, categories, orders, pages, homepage sections, settings, and media.
- كل النصوص والصور والألوان والمحتوى الظاهر في الواجهة قابل للتعديل من الداش بورد.
- المشروع قابل لإعادة الاستخدام كبداية لأي متجر جديد.

---

## 4. القاعدة الأساسية للمشروع

```txt
AdminLTE = الشكل والـ UI components فقط
Laravel = الـ architecture والـ business logic والـ CMS behavior
Database = مصدر المحتوى القابل للتعديل
Blade = عرض فقط بدون business logic
```

---

## 5. القيود الصارمة

### 5.1 ممنوعات عامة

يمنع الآتي:

- استخدام Filament كـ admin panel.
- بناء الداش بورد على structure AdminLTE الافتراضي كما هو.
- وضع محتوى أساسي hardcoded داخل Blade.
- وضع ألوان ثابتة في ملفات Blade بدون ربطها بالـ settings.
- وضع صور ثابتة داخل الواجهة بدون ربطها بالـ media/settings/sections.
- كتابة business logic داخل views.
- استخدام queries مباشرة داخل Blade.
- تكرار forms وtables بشكل عشوائي بدون components.
- حذف بيانات مهمة نهائيًا بدون confirmation أو soft delete عند الحاجة.
- بناء صفحات frontend ثابتة غير قابلة للتعديل.
- جعل الـ navbar أو footer أو homepage sections ثابتة في الكود.
- تنفيذ payment integrations في البداية بشكل معقد قبل تجهيز structure عام.
- استخدام packages تفرض architecture لا تناسب المشروع.
- الاعتماد على MySQL فقط أو SQLite فقط بطريقة تكسر المحرك الآخر.
- استخدام raw SQL خاص بمحرك database معين بدون ضرورة موثقة.

### 5.2 المطلوب الالتزام به

يجب الالتزام بالآتي:

- كل المحتوى القابل للتغيير يجب أن يأتي من database.
- كل module في الداش بورد يجب أن يتبع نفس نمط الصفحات.
- كل صفحة list يجب أن تحتوي على search, filters, pagination, empty state.
- كل form يجب أن يستخدم validation واضحة.
- كل upload يجب أن يمر من media system أو upload component موحد.
- كل setting يجب أن يكون قابلًا للتعديل من dashboard.
- كل route خاصة بالـ admin يجب أن تكون محمية middleware.
- كل action مهم يجب أن يسجل activity log.
- كل module يجب أن يكون له permissions.
- كل demo data يجب أن يتم إنشاؤها من seeders.
- كل demo media يجب أن تكون قابلة للاستبدال لاحقًا.
- كل migrations يجب أن تكون متوافقة مع SQLite وMySQL قدر الإمكان.
- SQLite يجب أن يظل default للتجربة السريعة، وMySQL هو recommended للـ production.

---

## 6. هيكل الداش بورد المقترح

Sidebar يجب أن يكون منظمًا بالشكل التالي:

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
- Variants
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
- Menus

Settings
- Store Settings
- SEO Settings
- Shipping Settings
- Payment Settings
- Tax Settings
- Email Settings

Users
- Admin Users
- Roles
- Permissions

System
- Activity Logs
- Export
- Cache / Maintenance
```

---

## 7. الصفحات الأساسية في الواجهة الأمامية

يجب تجهيز الصفحات التالية:

- Home
- Shop
- Product Details
- Category Products
- Cart
- Checkout
- Order Success
- Login
- Register
- Contact
- Static Page Template
- Privacy Policy
- Terms & Conditions

---

## 8. الفلو الكامل للمستخدم

### 8.1 Customer Flow

```txt
Home
→ Shop
→ Product Details
→ Add to Cart
→ Cart
→ Checkout
→ Order Success
```

### 8.2 Admin Flow

```txt
Admin Login
→ Dashboard
→ Manage Products
→ Manage Categories
→ View Orders
→ Update Order Status
→ Manage Pages
→ Edit Homepage Sections
→ Change Logo / Colors / Settings
→ Frontend updates automatically
```

---

## 9. الصفحات الداخلية لكل Module

أي module في الداش بورد يجب أن يتبع نفس النمط:

```txt
index.blade.php   → List / Table
create.blade.php  → Create Form
edit.blade.php    → Edit Form
show.blade.php    → Details Page
_form.blade.php   → Shared Form
_filters.blade.php → Filters
```

مثال Products:

```txt
resources/views/admin/products/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
├── show.blade.php
├── _form.blade.php
└── _filters.blade.php
```

---

## 10. الـ Modules الأساسية

## 10.1 Authentication

المطلوب:

- Admin login
- Logout
- Forgot password
- Reset password
- Admin middleware
- Protected admin routes
- Default admin user seeder

---

## 10.2 Dashboard

يجب أن تحتوي على:

- Total products
- Total orders
- Total sales
- Total customers
- Latest orders
- Latest products
- Low stock products
- Quick actions
- Store overview cards

---

## 10.3 Products Management

الحقول المطلوبة:

- Name
- Slug
- Short description
- Description
- Price
- Sale price
- SKU
- Stock quantity
- Status
- Category
- Brand optional
- Featured product
- Product images
- SEO title
- SEO description
- SEO image
- Meta robots

الصفحات المطلوبة:

- Products list
- Create product
- Edit product
- Product details
- Delete / archive product
- Search
- Filters
- Pagination
- Bulk actions لاحقًا

---

## 10.4 Categories Management

الحقول المطلوبة:

- Name
- Slug
- Parent category optional
- Image
- Description
- Status
- Sort order
- SEO title
- SEO description
- SEO image

---

## 10.5 Orders Management

المطلوب:

- Orders list
- Order details
- Customer info
- Order items
- Payment summary
- Shipping info
- Order status timeline
- Admin notes
- Update status

حالات الطلب:

```txt
pending
processing
completed
cancelled
refunded
```

---

## 10.6 Cart & Checkout

نسخة MVP يجب أن تحتوي على:

- Add to cart
- Remove from cart
- Update quantity
- Cart summary
- Checkout form
- Customer name
- Email
- Phone
- Address
- Notes
- Create order
- Order success page

الدفع الإلكتروني يمكن إضافته لاحقًا، لكن يجب تجهيز structure يسمح بالإضافة بدون إعادة بناء كاملة.

---

## 10.7 Pages CMS

إدارة الصفحات من الداش بورد:

- Home page
- Shop page
- About page
- Contact page
- Privacy policy
- Terms & conditions
- Static pages

الحقول:

- Title
- Slug
- Content
- Status
- SEO title
- SEO description
- SEO image
- Sort order

---

## 10.8 Homepage Sections / Page Builder بسيط

لا نريد بناء Elementor كامل.

المطلوب Page Sections System بسيط:

أنواع sections مبدئية:

```txt
hero
banner
category_grid
featured_products
new_arrivals
offer_banner
text_image
testimonials
faq
newsletter
cta
```

كل section يجب أن يكون:

- Editable
- Reorderable
- Can be activated/deactivated
- Has its own data
- Has its own frontend partial

مثال render:

```php
@foreach($sections as $section)
    @includeIf('frontend.sections.' . $section->type, ['section' => $section])
@endforeach
```

---

## 10.9 Theme & Store Settings

من الداش بورد يجب تعديل:

- Store name
- Logo
- Favicon
- Primary color
- Secondary color
- Footer text
- Contact email
- Phone number
- WhatsApp number
- Address
- Facebook URL
- Instagram URL
- TikTok URL
- YouTube URL
- Default SEO title
- Default SEO description
- Google Analytics ID
- Facebook Pixel ID

---

## 10.10 Demo Experience

المشروع يجب أن يأتي جاهزًا بتجربة demo كاملة:

- Demo admin user
- Demo logo
- Demo favicon
- Demo hero image
- Demo banners
- Demo categories
- Demo products
- Demo orders
- Demo customers
- Demo pages
- Demo homepage sections
- Demo settings
- Demo menus

يجب ألا تكون الديمو داتا hardcoded، بل يتم إنشاؤها من seeders.

---

# 11. المتطلبات الإضافية الـ 13

## 11.1 Roles & Permissions

يجب دعم roles و permissions من البداية.

أدوار مبدئية:

```txt
Super Admin
Admin
Content Manager
Product Manager
Order Manager
```

Permissions مبدئية:

```txt
manage products
manage categories
manage orders
manage pages
manage media
manage settings
manage users
manage roles
manage menus
view activity logs
export data
```

---

## 11.2 Menu Builder

يجب وجود menu builder شبيه بفكرة WordPress.

المكان:

```txt
Appearance > Menus
```

القوائم المطلوبة:

- Header Menu
- Footer Menu
- Mobile Menu

أنواع links:

- Page
- Category
- Product
- Custom URL

القوائم لا يجب أن تكون hardcoded في Blade.

---

## 11.3 Real Media Library

يجب بناء Media Library حقيقية، ليست مجرد upload داخل المنتجات.

المطلوب:

- Upload files
- View files
- Search files
- Filter by type
- Copy file URL
- Delete unused media
- Select image from media modal
- Use same media item in multiple places

المكان:

```txt
Content > Media Library
```

---

## 11.4 SEO System

يجب وجود SEO system عام.

لكل صفحة / منتج / تصنيف:

- SEO title
- SEO description
- SEO image
- Canonical URL
- Meta robots
- Slug

Settings عامة:

- Default SEO title
- Default SEO description
- Default sharing image
- Google Analytics ID
- Facebook Pixel ID

---

## 11.5 Email Templates & Notifications

يجب تجهيز email templates أساسية.

Templates مبدئية:

- Order placed
- Order status changed
- Password reset
- Contact form message

المكان المقترح:

```txt
Settings > Email Templates
```

في MVP يمكن أن تكون templates بسيطة، لكن structure يجب أن يسمح بتطويرها لاحقًا.

---

## 11.6 Shipping, Payment & Tax Settings

حتى لو لم يتم تنفيذ payment integrations في البداية، يجب تجهيز الإعدادات.

المكان:

```txt
Settings > Shipping
Settings > Payment
Settings > Tax
```

MVP:

- Cash on delivery
- Flat shipping rate
- Free shipping threshold
- Tax percentage

---

## 11.7 Customer Management

يجب وجود customers module.

المطلوب:

- Customers list
- Customer details
- Customer orders
- Customer addresses
- Customer status

حتى لو checkout guest، يجب تخزين بيانات العميل بشكل منظم.

---

## 11.8 Activity Log

يجب تسجيل الأحداث المهمة.

أمثلة:

```txt
Admin updated product
Admin changed order status
Admin changed theme color
Admin deleted media item
Admin updated settings
```

المكان:

```txt
System > Activity Logs
```

---

## 11.9 Export / Backup Preparation

في MVP على الأقل يجب تجهيز export للبيانات المهمة.

Exports مبدئية:

- Products CSV
- Orders CSV
- Customers CSV

Backup كامل يمكن إضافته لاحقًا.

---

## 11.10 Reusable Admin Components

يجب إنشاء components موحدة لتقليل التكرار.

Components مبدئية:

```txt
admin.components.card
admin.components.table
admin.components.form.input
admin.components.form.textarea
admin.components.form.select
admin.components.form.checkbox
admin.components.form.image-upload
admin.components.form.media-picker
admin.components.status-badge
admin.components.empty-state
admin.components.confirm-delete
admin.components.breadcrumb
admin.components.flash-message
```

---

## 11.11 Install / Setup Flow

بما أن المشروع starter kit، يجب أن يكون تشغيله واضحًا.

Commands مبدئية:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

لاحقًا يمكن إضافة command:

```bash
php artisan app:install
```

---

## 11.12 Documentation

يجب وجود README واضح.

الـ README يجب أن يشرح:

- How to install
- Default admin login
- Project structure
- How to add new admin module
- How settings work
- How page sections work
- How demo data works
- How to customize theme
- How to replace demo media
- How to add permissions

---

## 11.13 Frontend Theme Structure

يجب تنظيم الواجهة الأمامية بحيث تسمح بتغيير الثيم لاحقًا.

مثال structure:

```txt
resources/views/frontend/themes/default/
```

أو:

```txt
resources/views/storefront/
```

المهم ألا يكون frontend مبنيًا بعشوائية تمنع إضافة theme جديد لاحقًا.

---

# 12. متطلبات UX إضافية مهمة

## 12.1 Empty States

كل صفحة list يجب أن تحتوي على empty state واضح.

أمثلة:

- No products yet
- No orders found
- No media uploaded
- No pages created

## 12.2 Error States

يجب عرض errors بشكل واضح عند:

- Validation failure
- Upload failure
- Permission denied
- Resource not found
- Delete blocked because item is used

## 12.3 Confirmation Actions

أي action خطر يجب أن يحتاج confirmation.

أمثلة:

- Delete product
- Delete media
- Cancel order
- Change order status to refunded
- Disable user

## 12.4 System / Maintenance

يفضل تجهيز System section لاحقًا يحتوي على:

- Clear cache
- App version
- Environment info
- Storage link status
- Maintenance mode

---

# 13. Database Structure مبدئي

الجداول المقترحة:

```txt
users
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions

settings
media
menus
menu_items

pages
page_sections

categories
products
product_images
brands
attributes
attribute_values
product_variants

customers
customer_addresses
orders
order_items
order_status_histories

coupons
activity_logs
email_templates
```

الجداول التي يمكن تأجيلها بعد MVP:

```txt
brands
attributes
attribute_values
product_variants
coupons
advanced backups
advanced payment integrations
```

---



## 13.1 Database Engine Policy

### الهدف

يجب أن يكون المشروع سهل التشغيل كـ starter kit، وفي نفس الوقت جاهزًا للتحويل إلى production store حقيقي.

لذلك يتم اعتماد السياسة التالية:

```txt
SQLite = default local/demo database
MySQL  = recommended production database
```

### SQLite

يستخدم SQLite في:

- التشغيل المحلي السريع.
- تجربة المشروع لأول مرة.
- demo data.
- الاختبارات الآلية.
- بيئات CI إن وجدت.

ملف `.env.example` يمكن أن يبدأ بهذا الشكل:

```env
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

ويجب أن يتم إنشاء ملف:

```txt
database/database.sqlite
```

يدويًا أو من خلال install command لاحقًا.

### MySQL

يستخدم MySQL في:

- المشاريع الحقيقية.
- staging.
- production.
- المتاجر التي تحتوي على عدد كبير من المنتجات أو الطلبات أو العملاء.
- التقارير والبحث والفلاتر المتقدمة.

مثال إعدادات MySQL في `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store_db
DB_USERNAME=root
DB_PASSWORD=
```

### قواعد التوافق بين SQLite وMySQL

يجب الالتزام بالآتي:

- استخدام Laravel migrations بدل raw SQL.
- استخدام Eloquent/Query Builder بدل SQL خاص بمحرك معين.
- تجنب database-specific SQL إلا عند الضرورة ومع توثيق السبب.
- تجنب استخدام `enum` database-level، واستخدام `string` للحالات بدلًا منه.
- التعامل بحذر مع JSON columns والتأكد أنها تعمل في SQLite وMySQL.
- عدم الاعتماد على full-text indexes في الـ MVP إلا مع fallback واضح.
- كل status fields تكون `string` مثل `active`, `inactive`, `pending`, `completed`.
- اختبار `php artisan migrate:fresh --seed` على SQLite على الأقل قبل اعتبار أي milestone مكتمل.
- عند إضافة دعم production، يجب اختبار نفس الأمر على MySQL أيضًا.

مثال مقبول:

```php
$table->string('status')->default('active');
```

مثال غير مفضل في هذا المشروع:

```php
$table->enum('status', ['active', 'inactive']);
```

### Acceptance Criteria للـ Database Policy

- المشروع يعمل محليًا باستخدام SQLite بدون إعداد MySQL.
- يمكن تحويله إلى MySQL من `.env` بدون تغيير الكود.
- كل seeders تعمل على SQLite.
- كل migrations لا تعتمد على features خاصة بـ MySQL فقط.
- README يشرح تشغيل SQLite وتحويل الإعدادات إلى MySQL.

# 14. Structure مقترح للمشروع

```txt
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── OrderController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── PageController.php
│   │   │   ├── SectionController.php
│   │   │   ├── MediaController.php
│   │   │   ├── MenuController.php
│   │   │   ├── SettingController.php
│   │   │   └── ActivityLogController.php
│   │   └── Frontend/
│   │       ├── HomeController.php
│   │       ├── ShopController.php
│   │       ├── ProductController.php
│   │       ├── CartController.php
│   │       └── CheckoutController.php
│   └── Requests/
│       └── Admin/

resources/
├── views/
│   ├── admin/
│   │   ├── layouts/
│   │   ├── partials/
│   │   ├── components/
│   │   ├── dashboard/
│   │   ├── products/
│   │   ├── categories/
│   │   ├── orders/
│   │   ├── customers/
│   │   ├── pages/
│   │   ├── sections/
│   │   ├── media/
│   │   ├── menus/
│   │   ├── settings/
│   │   └── system/
│   └── frontend/
│       └── themes/
│           └── default/
│               ├── layouts/
│               ├── sections/
│               ├── home.blade.php
│               ├── shop.blade.php
│               ├── product-details.blade.php
│               ├── cart.blade.php
│               └── checkout.blade.php

database/
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── AdminUserSeeder.php
│   ├── RolePermissionSeeder.php
│   ├── SettingSeeder.php
│   ├── DemoMediaSeeder.php
│   ├── CategorySeeder.php
│   ├── ProductSeeder.php
│   ├── PageSeeder.php
│   ├── SectionSeeder.php
│   ├── MenuSeeder.php
│   ├── CustomerSeeder.php
│   └── OrderSeeder.php
└── demo-media/
    ├── logo.png
    ├── favicon.png
    ├── hero.jpg
    ├── banners/
    ├── categories/
    └── products/
```

---

# 15. Demo Media Rules

Demo media يجب أن تكون:

- موجودة داخل المشروع في مكان واضح.
- يتم نسخها إلى storage أثناء seeding.
- يتم حفظ مساراتها في database.
- قابلة للتغيير من الداش بورد.
- غير hardcoded داخل Blade.

مسار مقترح:

```txt
database/demo-media/
```

ثم أثناء seeding يتم نسخها إلى:

```txt
storage/app/public/demo/
```

ثم يتم عرضها من:

```txt
public/storage/demo/
```

---

# 16. Settings System

جدول settings:

```txt
settings
- id
- group
- key
- value
- type
- created_at
- updated_at
```

أمثلة:

```txt
general.site_name
general.logo
general.favicon
theme.primary_color
theme.secondary_color
contact.email
contact.phone
contact.whatsapp
social.facebook
social.instagram
seo.default_title
seo.default_description
```

يجب توفير helper:

```php
setting('general.site_name')
setting('theme.primary_color', '#111827')
```

---

# 17. Page Sections System

جدول page_sections:

```txt
page_sections
- id
- page_id
- type
- title
- subtitle
- content
- image
- button_text
- button_url
- settings JSON
- sort_order
- is_active
- created_at
- updated_at
```

كل section type يجب أن يكون له Blade partial منفصل.

مثال:

```txt
resources/views/frontend/themes/default/sections/hero.blade.php
resources/views/frontend/themes/default/sections/banner.blade.php
resources/views/frontend/themes/default/sections/featured-products.blade.php
```

---

# 18. Plan / Milestones

## Milestone 1: Project Foundation

- Create Laravel project
- Configure auth
- Install and integrate AdminLTE assets
- Create admin layout
- Create sidebar
- Create dashboard page
- Create protected admin routes

## Milestone 2: Core CMS Foundation

- Settings table
- Settings helper
- Media table
- Media upload
- Demo media seeder
- Reusable admin components

## Milestone 3: Content Modules

- Pages CRUD
- Page sections CRUD
- Menu builder
- SEO fields
- Frontend dynamic home page

## Milestone 4: Catalog Modules

- Categories CRUD
- Products CRUD
- Product images
- Product status
- Product SEO
- Demo products and categories

## Milestone 5: Sales Flow

- Cart
- Checkout
- Customers
- Orders
- Order details
- Order status update
- Demo orders

## Milestone 6: Admin Polish

- Roles and permissions
- Activity logs
- Email templates
- Empty states
- Error states
- Export CSV

## Milestone 7: Starter Kit Readiness

- README
- Install guide
- Demo data guide
- Theme customization guide
- Cleanup
- Final testing

---

# 19. MVP Scope

الـ MVP يجب أن يحتوي على الأقل على:

- Admin login
- AdminLTE dashboard layout
- Sidebar organized like CMS
- Settings module
- Media library basic version
- Pages module
- Homepage sections
- Menu builder basic version
- Categories module
- Products module
- Cart
- Checkout
- Orders
- Customers basic version
- SEO fields
- Demo seeders
- Demo media
- Reusable components
- README

---

# 20. خارج نطاق الـ MVP

هذه الأشياء يمكن تأجيلها:

- Advanced product variants
- Multi-vendor marketplace
- Advanced coupons system
- Online payment integrations
- Multi-language support
- Multi-currency support
- Advanced inventory warehouse system
- Advanced page builder مثل Elementor
- Full backup automation
- Advanced analytics dashboard
- API / headless mode

لكن يجب أن يكون structure المشروع يسمح بإضافتها لاحقًا بدون إعادة بناء كاملة.

---

# 21. Acceptance Criteria

المشروع يعتبر ناجحًا عندما:

- يمكن تشغيله من الصفر باستخدام migrations و seeders.
- يظهر متجر تجريبي كامل بعد أول تشغيل.
- يمكن تسجيل الدخول إلى admin dashboard.
- الداش بورد مبنية بـ AdminLTE لكن structure مخصص للمشروع.
- يمكن إدارة المنتجات والتصنيفات والطلبات من الداش بورد.
- يمكن إدارة الصفحات والـ homepage sections من الداش بورد.
- يمكن تغيير logo, favicon, colors, contact info, social links من الداش بورد.
- يمكن إدارة menus بدون تعديل الكود.
- كل صور الديمو والمحتوى قابل للتغيير من الداش بورد.
- لا يوجد محتوى أساسي hardcoded في Blade.
- كل list page تحتوي على search, filters, pagination, empty state.
- كل module له permissions.
- كل action مهم يتم تسجيله في activity log.
- يوجد README واضح للتشغيل والتخصيص.

---

# 22. Developer Rules

أي مطور يعمل على المشروع يجب أن يلتزم بالتالي:

- لا تضيف module جديد بدون routes, controller, request validation, views, permissions.
- لا تكرر form أو table إذا كان يمكن تحويله إلى component.
- لا تضع business logic داخل Blade.
- لا تضع إعدادات قابلة للتغيير داخل config فقط بدون dashboard إذا كانت تخص صاحب المتجر.
- لا تجعل أي image أساسية hardcoded.
- لا تكتب migration بدون التفكير في seeders وdemo data.
- لا تضيف package إلا لو لا يفرض architecture متعارضة مع المشروع.
- لا تكسر تجربة الديمو عند إضافة feature جديدة.
- أي feature جديدة يجب أن تكون قابلة لإعادة الاستخدام في مشاريع أخرى.

---

# 23. Summary

هذا المشروع ليس مجرد Laravel shop، وليس مجرد AdminLTE dashboard.

هو:

```txt
Reusable Laravel E-commerce CMS Starter Kit
```

بمواصفات:

```txt
Custom Laravel Architecture
AdminLTE UI
WordPress-like Admin Organization
Editable CMS Content
Demo-ready Store
Reusable Components
Strict Constraints
Clear Milestones
```

الهدف الأساسي هو تقليل وقت بناء المتاجر الجديدة، مع الحفاظ على تحكم كامل في الكود والواجهة والـ CMS behavior.
