<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Make extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'website_url',
        'is_active',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml'])
            ->singleFile();

        $this->addMediaCollection('logo_dark')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 150, 150)
            ->quality(90)
            ->format('png')
            ->performOnCollections('logo', 'logo_dark');

        $this->addMediaConversion('medium')
            ->fit(Fit::Contain, 300, 300)
            ->quality(90)
            ->format('png')
            ->performOnCollections('logo', 'logo_dark');

        $this->addMediaConversion('large')
            ->fit(Fit::Contain, 600, 600)
            ->quality(95)
            ->format('png')
            ->performOnCollections('logo', 'logo_dark');
    }

    // Helper methods for logo access
    public function getLogoUrl(string $conversion = ''): string
    {
        $logo = $this->getFirstMedia('logo');
        if (!$logo) {
            return '';
        }

        return $conversion ? $logo->getUrl($conversion) : $logo->getUrl();
    }

    public function getDarkLogoUrl(string $conversion = ''): string
    {
        $logo = $this->getFirstMedia('logo_dark');
        if (!$logo) {
            return $this->getLogoUrl($conversion); // Fallback to regular logo
        }

        return $conversion ? $logo->getUrl($conversion) : $logo->getUrl();
    }

    public function hasLogo(): bool
    {
        return $this->hasMedia('logo');
    }
}
