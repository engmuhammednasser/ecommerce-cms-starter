<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Services\Contracts\PaymentGatewayInterface;

class DummyPaymentGateway implements PaymentGatewayInterface
{
    public function isEnabled(): bool
    {
        return setting('payment.dummy_gateway_enabled', '0') === '1';
    }

    public function initiatePayment(Order $order): string
    {
        // In a real gateway, this would call the API to create a payment session
        // and return the redirect URL. For dummy, we just redirect to our callback directly
        // simulating a success. We pass the order_number as the transaction reference.

        return route('payment.dummy.callback', [
            'order_number' => $order->order_number,
            'status' => 'success',
        ]);
    }

    public function handleCallback(array $payload): array
    {
        // In a real gateway, this verifies the signature/webhook payload.
        
        $status = ($payload['status'] ?? '') === 'success' ? 'paid' : 'failed';
        
        return [
            'status' => $status,
            'transaction_id' => 'dummy_tx_' . uniqid(),
            'error' => $status === 'failed' ? 'Payment failed by user' : null,
        ];
    }
}
