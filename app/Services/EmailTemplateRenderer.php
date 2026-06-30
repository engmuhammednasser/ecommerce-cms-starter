<?php

namespace App\Services;

use App\Models\EmailTemplate;

class EmailTemplateRenderer
{
    /**
     * @param array<string, mixed> $data
     * @return array{subject: string, body: string}|null
     */
    public function render(string $key, array $data): ?array
    {
        $template = EmailTemplate::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        if (! $template) {
            return null;
        }

        return [
            'subject' => $this->replacePlaceholders($template->subject, $data),
            'body' => $this->replacePlaceholders($template->body, $data),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function replacePlaceholders(string $content, array $data): string
    {
        $replacements = [];

        foreach ($data as $key => $value) {
            $replacements['{{ '.$key.' }}'] = (string) $value;
        }

        return strtr($content, $replacements);
    }
}
