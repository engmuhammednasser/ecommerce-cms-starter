<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\FooterSettingController;
use App\Http\Controllers\Admin\HeaderSettingController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ThemeSettingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CatalogController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/shop', [CatalogController::class, 'shop'])->name('catalog.shop');
Route::get('/categories/{category:slug}', [CatalogController::class, 'category'])->name('catalog.categories.show');
Route::get('/products/{product:slug}', [CatalogController::class, 'product'])->name('catalog.products.show');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/items/{product}', [CartController::class, 'store'])->name('cart.items.store');
Route::patch('/cart/items/{cartKey}', [CartController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartKey}', [CartController::class, 'destroy'])->name('cart.items.destroy');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::any('/payment/callback/dummy', \App\Http\Controllers\Frontend\PaymentCallbackController::class)->name('payment.dummy.callback');

// Customer Auth
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('login', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'login'])->name('login.store');
        Route::get('register', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'register'])->name('register.store');
    });

    Route::middleware('auth:customer')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('orders', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'orders'])->name('orders');
        Route::get('addresses', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'addresses'])->name('addresses');
        Route::post('addresses', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'storeAddress'])->name('addresses.store');
        Route::delete('addresses/{address}', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'destroyAddress'])->name('addresses.destroy');
    });
});

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('admin.auth')->name('logout');

    Route::get('/dashboard', DashboardController::class)->middleware('admin.auth')->name('dashboard');
    Route::get('/settings', [SettingController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('settings.update');
    Route::get('/theme-settings', [ThemeSettingController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('theme-settings.index');
    Route::put('/theme-settings', [ThemeSettingController::class, 'update'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('theme-settings.update');
    Route::get('/header-settings', [HeaderSettingController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('header-settings.index');
    Route::put('/header-settings', [HeaderSettingController::class, 'update'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('header-settings.update');
    Route::get('/footer-settings', [FooterSettingController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('footer-settings.index');
    Route::put('/footer-settings', [FooterSettingController::class, 'update'])->middleware(['admin.auth', 'admin.permission:manage appearance'])->name('footer-settings.update');
    Route::get('/media', [MediaController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage media'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->middleware(['admin.auth', 'admin.permission:manage media,manage products,manage pages,manage settings'])->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->middleware(['admin.auth', 'admin.permission:manage media'])->name('media.destroy');
    Route::resource('pages', PageController::class)->middleware(['admin.auth', 'admin.permission:manage pages']);
    Route::resource('sections', SectionController::class)->middleware(['admin.auth', 'admin.permission:manage pages']);
    Route::resource('menus', MenuController::class)->middleware(['admin.auth', 'admin.permission:manage menus']);
    Route::resource('shipping-zones', \App\Http\Controllers\Admin\ShippingZoneController::class)->middleware(['admin.auth', 'admin.permission:manage settings']);
    Route::resource('shipping-zones.rates', \App\Http\Controllers\Admin\ShippingRateController::class)->except(['index', 'show'])->middleware(['admin.auth', 'admin.permission:manage settings']);
    Route::resource('brands', BrandController::class)->middleware(['admin.auth', 'admin.permission:manage products']);
    Route::resource('attributes', AttributeController::class)->parameters(['attributes' => 'attribute'])->middleware(['admin.auth', 'admin.permission:manage products']);
    Route::resource('categories', CategoryController::class)->middleware(['admin.auth', 'admin.permission:manage products']);
    Route::resource('products', ProductController::class)->middleware(['admin.auth', 'admin.permission:manage products']);
    Route::resource('products.variants', \App\Http\Controllers\Admin\ProductVariantController::class)
        ->except(['index', 'show'])
        ->middleware(['admin.auth', 'admin.permission:manage products']);
    Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage products'])->name('inventory.index');
    Route::patch('/inventory/{product}', [\App\Http\Controllers\Admin\InventoryController::class, 'updateStock'])->middleware(['admin.auth', 'admin.permission:manage products'])->name('inventory.update');
    Route::get('/orders', [OrderController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('orders.status.update');
    Route::post('/orders/{order}/notes', [OrderController::class, 'addNote'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('orders.notes.store');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('orders.invoice');
    Route::get('/customers', [CustomerController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('customers.show');
    Route::resource('coupons', CouponController::class)->middleware(['admin.auth', 'admin.permission:manage orders']);
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('activity-logs.index');
    Route::get('/exports', [ExportController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('exports.index');
    Route::get('/exports/products', [ExportController::class, 'products'])->middleware(['admin.auth', 'admin.permission:manage products'])->name('exports.products');
    Route::get('/exports/orders', [ExportController::class, 'orders'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('exports.orders');
    Route::get('/exports/customers', [ExportController::class, 'customers'])->middleware(['admin.auth', 'admin.permission:manage orders'])->name('exports.customers');
    Route::get('/email-templates', [EmailTemplateController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('email-templates.index');
    Route::get('/email-templates/{emailTemplate}/edit', [EmailTemplateController::class, 'edit'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('email-templates.edit');
    Route::put('/email-templates/{emailTemplate}', [EmailTemplateController::class, 'update'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('email-templates.update');
    Route::post('/email-templates/preview', [EmailTemplateController::class, 'preview'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('email-templates.preview');
    Route::get('/email-templates/{emailTemplate}', [EmailTemplateController::class, 'show'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('email-templates.show');
    Route::resource('users', AdminUserController::class)->middleware(['admin.auth', 'admin.permission:manage users']);
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('maintenance.index');
    Route::post('/maintenance/clear-cache', [MaintenanceController::class, 'clear'])->middleware(['admin.auth', 'admin.permission:manage settings'])->name('maintenance.clear');
    Route::post('/menus/{menu}/items', [MenuController::class, 'storeItem'])->middleware(['admin.auth', 'admin.permission:manage menus'])->name('menus.items.store');
    Route::delete('/menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->middleware(['admin.auth', 'admin.permission:manage menus'])->name('menus.items.destroy');
});
