<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'is_active', 'meta_description', 'image', 'cta_text', 'cta_url'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
