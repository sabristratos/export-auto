<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FeaturedCars extends Component
{
    public int $limit = 3;

    #[Computed]
    public function cars()
    {
        return Car::with(['make', 'model', 'media', 'attributes.attribute'])
            ->published()
            ->featured()
            ->latest()
            ->limit($this->limit)
            ->get();
    }

    public function render()
    {
        return view('livewire.featured-cars');
    }
}