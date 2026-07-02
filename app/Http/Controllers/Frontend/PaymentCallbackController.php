<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Contracts\PaymentGatewayInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function __invoke(Request $request, PaymentGatewayInterface $paymentGateway): RedirectResponse
    {
        $orderNumber = $request->input('order_number');
        $order = Order::query()->where('order_number', $orderNumber)->firstOrFail();

        $result = $paymentGateway->handleCallback($request->all());

        $order->update([
            'payment_status' => $result['status'],
        ]);

        if ($result['status'] === 'paid') {
            return redirect()->route('checkout.success', $order)
                ->with('success', 'Payment was successful.');
        }

        return redirect()->route('checkout.success', $order)
            ->with('error', $result['error'] ?? 'Payment failed.');
    }
}
