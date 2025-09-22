<?php

namespace App\Models;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'type',
        'status',
        'source',
        'car_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
            'status' => LeadStatus::class,
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', LeadStatus::New);
    }

    public function scopeContacted($query)
    {
        return $query->where('status', LeadStatus::Contacted);
    }

    public function scopeConverted($query)
    {
        return $query->where('status', LeadStatus::Converted);
    }

    public function scopeGeneral($query)
    {
        return $query->where('type', LeadType::General);
    }

    public function scopeCarInquiry($query)
    {
        return $query->where('type', LeadType::CarInquiry);
    }

    public function scopeForCar($query, $carId)
    {
        return $query->where('car_id', $carId);
    }

    public function scopeFromSource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function markAsContacted(): void
    {
        $this->update(['status' => LeadStatus::Contacted]);
    }

    public function markAsConverted(): void
    {
        $this->update(['status' => LeadStatus::Converted]);
    }

    public function isNew(): bool
    {
        return $this->status === LeadStatus::New;
    }

    public function isContacted(): bool
    {
        return $this->status === LeadStatus::Contacted;
    }

    public function isConverted(): bool
    {
        return $this->status === LeadStatus::Converted;
    }

    public function isCarInquiry(): bool
    {
        return $this->type === LeadType::CarInquiry;
    }

    public function isGeneral(): bool
    {
        return $this->type === LeadType::General;
    }
}
