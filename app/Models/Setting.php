<?php

namespace App\Models;

use App\Enums\SettingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_public',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
            'type' => SettingType::class,
            'is_public' => 'boolean',
            'order' => 'integer',
        ];
    }

    public array $translatable = ['description', 'value'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files')
            ->acceptsMimeTypes(['image/*', 'application/pdf', 'text/*'])
            ->singleFile();

        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/*'])
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('images');

        $this->addMediaConversion('preview')
            ->width(500)
            ->height(500)
            ->sharpen(10)
            ->performOnCollections('images');
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_public', true);
    }

    public function scopeGroup(Builder $query, string $group): void
    {
        $query->where('group', $group);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('group')->orderBy('order')->orderBy('key');
    }

    public function getTypedValue(): mixed
    {
        return match ($this->type) {
            SettingType::Boolean => (bool) $this->value,
            SettingType::Integer, SettingType::Number => (int) $this->value,
            SettingType::Float => (float) $this->value,
            SettingType::Array, SettingType::Json => (array) $this->value,
            SettingType::File, SettingType::Image => $this->getFirstMediaUrl(),
            default => (string) $this->value,
        };
    }

    public function isFileType(): bool
    {
        return $this->type?->isFileType() ?? false;
    }

    public function getFileUrl(?string $conversion = null): ?string
    {
        if (!$this->isFileType()) {
            return null;
        }

        if ($conversion) {
            return $this->getFirstMediaUrl('files', $conversion)
                ?: $this->getFirstMediaUrl('images', $conversion);
        }

        return $this->getFirstMediaUrl('files')
            ?: $this->getFirstMediaUrl('images');
    }
}
