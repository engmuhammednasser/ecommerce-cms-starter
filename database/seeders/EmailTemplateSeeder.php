<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * @var array<int, array{key: string, name: string, subject: string, body: string, type: string, is_active: bool}>
     */
    private array $templates = [
        [
            'key' => 'order_placed',
            'name' => 'Order placed',
            'subject' => 'Order {{ order_number }} received',
            'body' => "Hello {{ customer_name }},\n\nThank you for your order {{ order_number }}.\n\nOrder total: {{ order_total }}\nOrder status: {{ order_status }}\n\nWe will contact you if anything else is needed.\n\n{{ store_name }}",
            'type' => 'order',
            'is_active' => true,
        ],
        [
            'key' => 'order_status_changed',
            'name' => 'Order status changed',
            'subject' => 'Order {{ order_number }} status updated',
            'body' => "Hello {{ customer_name }},\n\nYour order {{ order_number }} status changed from {{ old_status }} to {{ order_status }}.\n\n{{ store_name }}",
            'type' => 'order',
            'is_active' => true,
        ],
        [
            'key' => 'password_reset',
            'name' => 'Password reset',
            'subject' => 'Reset your {{ store_name }} password',
            'body' => "Hello {{ customer_name }},\n\nUse this link to reset your password:\n{{ reset_url }}\n\n{{ store_name }}",
            'type' => 'account',
            'is_active' => true,
        ],
        [
            'key' => 'contact_form_message',
            'name' => 'Contact form message',
            'subject' => 'New contact message from {{ customer_name }}',
            'body' => "Name: {{ customer_name }}\nEmail: {{ customer_email }}\nPhone: {{ customer_phone }}\n\nMessage:\n{{ message }}",
            'type' => 'contact',
            'is_active' => true,
        ],
    ];

    public function run(): void
    {
        foreach ($this->templates as $template) {
            EmailTemplate::query()->updateOrCreate(
                ['key' => $template['key']],
                [
                    'name' => $template['name'],
                    'subject' => $template['subject'],
                    'body' => $template['body'],
                    'type' => $template['type'],
                    'is_active' => $template['is_active'],
                ],
            );
        }
    }
}
