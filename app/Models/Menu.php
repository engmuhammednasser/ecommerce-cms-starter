<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'location'])]
class Menu extends Model
{
    public const LOCATIONS = [
        'header' => 'Header Menu',
        'footer' => 'Footer Menu',
        'mobile' => 'Mobile Menu',
    ];

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function locationLabel(): string
    {
        return self::LOCATIONS[$this->location] ?? ucfirst($this->location);
    }
}
