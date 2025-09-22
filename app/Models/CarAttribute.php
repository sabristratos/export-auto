<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarAttribute extends Model
{
    protected $fillable = [
        'car_id',
        'attribute_id',
        'value',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function scopeForCar($query, $carId)
    {
        return $query->where('car_id', $carId);
    }

    public function scopeForAttribute($query, $attributeId)
    {
        return $query->where('attribute_id', $attributeId);
    }

    public function scopeWithValue($query, $value)
    {
        return $query->where('value', $value);
    }

    public function getFormattedValueAttribute(): string
    {
        $attribute = $this->attribute;

        if (!$attribute) {
            return $this->value;
        }

        switch ($attribute->type) {
            case 'number':
                return $this->value . ($attribute->unit ? ' ' . $attribute->unit : '');
            case 'boolean':
                return $this->value === '1' ? 'Yes' : 'No';
            case 'select':
                $attributeValue = $attribute->values()->find($this->value);
                return $attributeValue ? $attributeValue->value : $this->value;
            default:
                return $this->value;
        }
    }
}
