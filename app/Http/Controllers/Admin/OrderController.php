<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ActivityLogger;
use App\Services\InventoryService;
use App\Services\OrderNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->with('customer')
            ->withCount('items')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('customer', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(
        Request $request,
        Order $order,
        ActivityLogger $activityLogger,
        OrderNotificationService $notifications,
        InventoryService $inventory,
    ): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Order::STATUSES))],
            'payment_status' => ['required', 'string', Rule::in(array_keys(Order::PAYMENT_STATUSES))],
            'fulfillment_status' => ['required', 'string', Rule::in(array_keys(Order::FULFILLMENT_STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;
        $oldFulfillmentStatus = $order->fulfillment_status;

        $order->update($validated);

        if ($oldStatus !== $order->status) {
            $order->histories()->create([
                'user_id' => auth()->id(),
                'action' => 'status_change',
                'comment' => "Status changed from {$oldStatus} to {$order->status}",
            ]);
        }

        if ($oldPaymentStatus !== $order->payment_status) {
            $order->histories()->create([
                'user_id' => auth()->id(),
                'action' => 'payment_change',
                'comment' => "Payment status changed from {$oldPaymentStatus} to {$order->payment_status}",
            ]);
        }

        if ($oldFulfillmentStatus !== $order->fulfillment_status) {
            $order->histories()->create([
                'user_id' => auth()->id(),
                'action' => 'fulfillment_change',
                'comment' => "Fulfillment status changed from {$oldFulfillmentStatus} to {$order->fulfillment_status}",
            ]);
        }

        // Restore stock when order moves to cancelled or refunded from another status
        $stockRestoreStatuses = ['cancelled', 'refunded'];
        if (in_array($order->status, $stockRestoreStatuses) && ! in_array($oldStatus, $stockRestoreStatuses)) {
            $inventory->restoreStockForOrder($order);
        }

        // Decrease stock if order moves back from cancelled/refunded to an active status
        if (in_array($oldStatus, $stockRestoreStatuses) && ! in_array($order->status, $stockRestoreStatuses)) {
            $inventory->decreaseStockForOrder($order);
        }

        $activityLogger->log('order_status_updated', $order, [
            'status' => [$oldStatus, $order->status],
            'payment_status' => [$oldPaymentStatus, $order->payment_status],
        ]);
        $notifications->orderStatusChanged($order, $oldStatus);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function addNote(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $order->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'manual_note',
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Note added to timeline.');
    }

    public function invoice(Order $order): View
    {
        $order->load('customer', 'items.product', 'items.variant');

        return view('admin.orders.invoice', compact('order'));
    }
}
