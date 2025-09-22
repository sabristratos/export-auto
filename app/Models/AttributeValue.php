<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    use HasTranslations;

    protected $fillable = [
        'attribute_id',
        'value',
        'display_order',
        'is_active',
    ];

    public array $translatable = ['value'];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('value');
    }

    public function scopeForAttribute($query, $attributeId)
    {
        return $query->where('attribute_id', $attributeId);
    }
}
