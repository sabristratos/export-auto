<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Review extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'customer_name',
        'customer_location',
        'content',
        'rating',
        'status',
        'car_id',
    ];

    public array $translatable = ['content'];

    protected function casts(): array
    {
        return [
            'status' => ReviewStatus::class,
            'rating' => 'integer',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', ReviewStatus::Approved);
    }

    public function scopePending($query)
    {
        return $query->where('status', ReviewStatus::Pending);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', ReviewStatus::Rejected);
    }

    public function scopeForCar($query, $carId)
    {
        return $query->where('car_id', $carId);
    }

    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeMinRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function approve(): void
    {
        $this->update(['status' => ReviewStatus::Approved]);
    }

    public function reject(): void
    {
        $this->update(['status' => ReviewStatus::Rejected]);
    }

    public function isApproved(): bool
    {
        return $this->status === ReviewStatus::Approved;
    }

    public function isPending(): bool
    {
        return $this->status === ReviewStatus::Pending;
    }

    public function isRejected(): bool
    {
        return $this->status === ReviewStatus::Rejected;
    }
}
