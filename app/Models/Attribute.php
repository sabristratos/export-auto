<?php

namespace App\Models;

use App\Enums\AttributeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'unit',
        'is_required',
        'is_filterable',
        'is_searchable',
        'display_order',
        'group',
        'description',
    ];

    public array $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'type' => AttributeType::class,
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
            'is_searchable' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function carAttributes(): HasMany
    {
        return $this->hasMany(CarAttribute::class);
    }

    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    public function scopeSearchable($query)
    {
        return $query->where('is_searchable', true);
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function isSelect(): bool
    {
        return $this->type === AttributeType::Select;
    }

    public function isNumeric(): bool
    {
        return $this->type === AttributeType::Number;
    }

    public function isBoolean(): bool
    {
        return $this->type === AttributeType::Boolean;
    }
}
