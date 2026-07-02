<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Check if the gateway is enabled in settings.
     */
    public function isEnabled(): bool;

    /**
     * Initiate the payment and return a redirect URL for the customer.
     */
    public function initiatePayment(Order $order): string;

    /**
     * Handle the gateway callback or webhook.
     *
     * @param array<string, mixed> $payload
     * @return array{status: string, transaction_id: string|null, error: string|null}
     */
    public function handleCallback(array $payload): array;
}
