<?php

namespace App\Models;

use App\Enums\CarStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Car extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'make_id',
        'model_id',
        'slug',
        'status',
        'price',
        'currency',
        'featured',
        'description',
    ];

    public array $translatable = ['description'];

    protected function casts(): array
    {
        return [
            'status' => CarStatus::class,
            'price' => 'decimal:2',
            'featured' => 'boolean',
        ];
    }

    public function make(): BelongsTo
    {
        return $this->belongsTo(Make::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(CarAttribute::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', CarStatus::Published);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->whereIn('status', [CarStatus::Draft, CarStatus::Published]);
    }

    public function scopeByMake($query, $makeId)
    {
        return $query->where('make_id', $makeId);
    }

    public function scopeByModel($query, $modelId)
    {
        return $query->where('model_id', $modelId);
    }

    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }
}
