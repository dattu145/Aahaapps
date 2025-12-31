<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeImage extends Model
{
    protected $fillable = ['image_path', 'sort_order', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
