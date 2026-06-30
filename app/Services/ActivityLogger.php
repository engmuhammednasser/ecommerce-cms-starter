<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * @param array<string, mixed> $properties
     */
    public function log(string $action, ?Model $subject = null, array $properties = []): void
    {
        $user = Auth::user();

        ActivityLog::query()->create([
            'user_id' => $user?->id,
            'actor_name' => $user?->name,
            'action' => $action,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'subject_name' => $this->subjectName($subject),
            'properties' => $properties === [] ? null : $properties,
        ]);
    }

    private function subjectName(?Model $subject): ?string
    {
        if (! $subject) {
            return null;
        }

        foreach (['name', 'title', 'order_number', 'key'] as $attribute) {
            $value = $subject->getAttribute($attribute);

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return (string) $subject->getKey();
    }
}
