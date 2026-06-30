<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OrderNotificationService
{
    public function __construct(private readonly EmailTemplateRenderer $renderer)
    {
    }

    public function orderPlaced(Order $order): void
    {
        $this->sendOrderTemplate('order_placed', $order);
    }

    public function orderStatusChanged(Order $order, string $oldStatus): void
    {
        $this->sendOrderTemplate('order_status_changed', $order, [
            'old_status' => $this->formatStatus($oldStatus),
        ]);
    }

    /**
     * @param array<string, mixed> $extraData
     */
    private function sendOrderTemplate(string $templateKey, Order $order, array $extraData = []): void
    {
        if (! $order->customer_email) {
            return;
        }

        $message = $this->renderer->render($templateKey, array_merge($this->orderData($order), $extraData));

        if (! $message) {
            return;
        }

        try {
            Mail::send('emails.template', ['body' => $message['body']], function ($mail) use ($order, $message): void {
                $mail->to($order->customer_email, $order->customer_name)
                    ->subject($message['subject']);
            });
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    /**
     * @return array<string, string>
     */
    private function orderData(Order $order): array
    {
        return [
            'store_name' => setting('general.site_name', config('app.name', 'Laravel')),
            'order_number' => $order->order_number,
            'order_status' => $this->formatStatus($order->status),
            'order_total' => number_format((float) $order->total, 2),
            'customer_name' => $order->customer_name,
            'customer_email' => (string) $order->customer_email,
            'customer_phone' => (string) $order->customer_phone,
        ];
    }

    private function formatStatus(string $status): string
    {
        return ucfirst(str_replace(['_', '-'], ' ', $status));
    }
}
