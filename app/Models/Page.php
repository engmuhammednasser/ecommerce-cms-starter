<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'content',
    'status',
    'seo_title',
    'seo_description',
    'seo_image',
    'canonical_url',
    'meta_robots',
])]
class Page extends Model
{
}
