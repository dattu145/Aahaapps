<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CircularItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'link',
        'color',
        'text_color',
        'is_active',
        'sort_order',
        // Section 1
        'section1_images',
        'section1_image_width',
        'section1_image_height',
        // Section 2
        'section2_image',
        // Section 3
        'buttons',
        'enquiry_link',
        // Color overrides
        'card_bg_color',
        'title_color',
        'desc_color'
    ];

    protected $casts = [
        'section1_images' => 'array',
        'buttons' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
