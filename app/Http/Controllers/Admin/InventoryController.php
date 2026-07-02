<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $lowStockThreshold = (int) setting('inventory.low_stock_threshold', 5);

        $products = Product::query()
            ->with('category', 'primaryImage')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search): void {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->input('filter') === 'low_stock', function ($query) use ($lowStockThreshold): void {
                $query->where('stock_quantity', '<=', $lowStockThreshold)->where('stock_quantity', '>', 0);
            })
            ->when($request->input('filter') === 'out_of_stock', function ($query): void {
                $query->where('stock_quantity', '<=', 0);
            })
            ->orderBy('stock_quantity')
            ->paginate(20)
            ->withQueryString();

        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock_quantity', '<=', $lowStockThreshold)->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();

        return view('admin.inventory.index', compact(
            'products',
            'lowStockThreshold',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
        ));
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock_quantity' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', "Stock updated for {$product->name}.");
    }
}
