<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CircularItem extends Model
{
    protected $fillable = ['title', 'description', 'button_text', 'link', 'is_active', 'sort_order'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
