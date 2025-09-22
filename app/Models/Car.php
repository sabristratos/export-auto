<?php

namespace App\Models;

use App\Enums\CarStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->useFallbackUrl('/images/car-placeholder.jpg');

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 200)
            ->quality(90)
            ->format('webp')
            ->performOnCollections('photos', 'gallery');

        $this->addMediaConversion('preview')
            ->fit(Fit::Crop, 600, 400)
            ->quality(85)
            ->format('webp')
            ->performOnCollections('photos', 'gallery');

        $this->addMediaConversion('large')
            ->fit(Fit::Contain, 1200, 800)
            ->quality(85)
            ->format('webp')
            ->performOnCollections('photos', 'gallery');
    }

    // Helper methods for photo access
    public function getMainPhotoUrl(string $conversion = ''): string
    {
        $photo = $this->getFirstMedia('photos');
        if (!$photo) {
            return 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=1200&auto=format&fit=crop';
        }

        return $conversion ? $photo->getUrl($conversion) : $photo->getUrl();
    }

    public function hasPhotos(): bool
    {
        return $this->hasMedia('photos');
    }
}
