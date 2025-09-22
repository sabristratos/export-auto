<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $fillable = [
        'make_id',
        'name',
        'slug',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function make(): BelongsTo
    {
        return $this->belongsTo(Make::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'model_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForMake($query, $makeId)
    {
        return $query->where('make_id', $makeId);
    }
}
