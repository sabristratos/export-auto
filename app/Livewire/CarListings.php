<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Make;
use App\Models\CarModel;
use Livewire\Component;
use Livewire\WithPagination;

class CarListings extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $selectedMake = '';
    public $selectedModel = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $selectedYear = '';
    public $selectedFuelType = '';
    public $selectedTransmission = '';
    public $minMileage = '';
    public $maxMileage = '';
    public $featuredOnly = false;
    public $make = ''; // Make slug from URL

    // Sort properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Layout properties
    public $perPage = 12;
    public $showMobileFilters = false;

    // Available filter options
    public $makes;
    public $models;
    public $years;
    public $fuelTypes;
    public $transmissions;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedMake' => ['except' => ''],
        'selectedModel' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'selectedYear' => ['except' => ''],
        'selectedFuelType' => ['except' => ''],
        'selectedTransmission' => ['except' => ''],
        'minMileage' => ['except' => ''],
        'maxMileage' => ['except' => ''],
        'featuredOnly' => ['except' => false],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
        'make' => ['except' => ''], // Support make slug from URL
    ];

    public function mount()
    {
        $this->loadFilterOptions();

        // Handle make slug from URL parameter
        if ($this->make) {
            $makeModel = Make::where('slug', $this->make)->first();
            if ($makeModel) {
                $this->selectedMake = $makeModel->id;
                $this->updatedSelectedMake(); // Load models for this make
            }
        }
    }

    public function loadFilterOptions()
    {
        // Load makes that have published cars
        $this->makes = Make::active()
            ->whereHas('cars', function ($query) {
                $query->published();
            })
            ->withCount(['cars' => function ($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();

        // Initialize models collection
        $this->models = collect();

        // Get unique years from car attributes
        $this->years = Car::published()
            ->join('car_attributes', 'cars.id', '=', 'car_attributes.car_id')
            ->join('attributes', 'car_attributes.attribute_id', '=', 'attributes.id')
            ->where('attributes.slug', 'year')
            ->whereNotNull('car_attributes.value')
            ->distinct()
            ->pluck('car_attributes.value')
            ->sort()
            ->values();

        // Get unique fuel types
        $this->fuelTypes = Car::published()
            ->join('car_attributes', 'cars.id', '=', 'car_attributes.car_id')
            ->join('attributes', 'car_attributes.attribute_id', '=', 'attributes.id')
            ->where('attributes.slug', 'fuel_type')
            ->whereNotNull('car_attributes.value')
            ->distinct()
            ->pluck('car_attributes.value')
            ->sort()
            ->values();

        // Get unique transmission types
        $this->transmissions = Car::published()
            ->join('car_attributes', 'cars.id', '=', 'car_attributes.car_id')
            ->join('attributes', 'car_attributes.attribute_id', '=', 'attributes.id')
            ->where('attributes.slug', 'transmission')
            ->whereNotNull('car_attributes.value')
            ->distinct()
            ->pluck('car_attributes.value')
            ->sort()
            ->values();
    }

    public function updatedSelectedMake()
    {
        $this->selectedModel = '';
        $this->resetPage();

        if ($this->selectedMake) {
            $this->models = CarModel::where('make_id', $this->selectedMake)
                ->whereHas('cars', function ($query) {
                    $query->published();
                })
                ->withCount(['cars' => function ($query) {
                    $query->published();
                }])
                ->orderBy('name')
                ->get();
        } else {
            $this->models = collect();
        }
    }

    public function updated($propertyName)
    {
        // Reset page whenever any filter property is updated
        if (in_array($propertyName, [
            'search', 'selectedModel', 'minPrice', 'maxPrice', 'selectedYear',
            'selectedFuelType', 'selectedTransmission', 'minMileage', 'maxMileage',
            'featuredOnly', 'sortBy'
        ])) {
            $this->resetPage();
        }
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedSortBy($value)
    {
        // Handle combined sort options
        if ($value === 'price_asc') {
            $this->sortBy = 'price';
            $this->sortDirection = 'asc';
        } elseif ($value === 'price_desc') {
            $this->sortBy = 'price';
            $this->sortDirection = 'desc';
        } elseif ($value === 'featured') {
            $this->sortBy = 'featured';
            $this->sortDirection = 'desc';
        } else {
            $this->sortBy = $value;
            $this->sortDirection = 'desc';
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'selectedMake',
            'selectedModel',
            'minPrice',
            'maxPrice',
            'selectedYear',
            'selectedFuelType',
            'selectedTransmission',
            'minMileage',
            'maxMileage',
            'featuredOnly'
        ]);
        $this->models = collect();
        $this->resetPage();
    }

    public function toggleMobileFilters()
    {
        $this->showMobileFilters = !$this->showMobileFilters;
    }

    public function getActiveFiltersCountProperty()
    {
        $count = 0;

        if ($this->search) $count++;
        if ($this->selectedMake) $count++;
        if ($this->selectedModel) $count++;
        if ($this->minPrice || $this->maxPrice) $count++;
        if ($this->selectedYear) $count++;
        if ($this->selectedFuelType) $count++;
        if ($this->selectedTransmission) $count++;
        if ($this->minMileage || $this->maxMileage) $count++;
        if ($this->featuredOnly) $count++;

        return $count;
    }

    public function getFilteredCarsProperty()
    {
        $query = Car::published()
            ->with(['make', 'model', 'attributes.attribute']);

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('make', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('model', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Make filter
        if ($this->selectedMake) {
            $query->where('make_id', $this->selectedMake);
        }

        // Model filter
        if ($this->selectedModel) {
            $query->where('model_id', $this->selectedModel);
        }

        // Price filters
        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Year filter
        if ($this->selectedYear) {
            $query->whereHas('attributes', function ($q) {
                $q->whereHas('attribute', function ($q) {
                    $q->where('slug', 'year');
                })->where('value', $this->selectedYear);
            });
        }

        // Fuel type filter
        if ($this->selectedFuelType) {
            $query->whereHas('attributes', function ($q) {
                $q->whereHas('attribute', function ($q) {
                    $q->where('slug', 'fuel_type');
                })->where('value', $this->selectedFuelType);
            });
        }

        // Transmission filter
        if ($this->selectedTransmission) {
            $query->whereHas('attributes', function ($q) {
                $q->whereHas('attribute', function ($q) {
                    $q->where('slug', 'transmission');
                })->where('value', $this->selectedTransmission);
            });
        }

        // Mileage filters
        if ($this->minMileage) {
            $query->whereHas('attributes', function ($q) {
                $q->whereHas('attribute', function ($q) {
                    $q->where('slug', 'mileage');
                })->where('value', '>=', $this->minMileage);
            });
        }
        if ($this->maxMileage) {
            $query->whereHas('attributes', function ($q) {
                $q->whereHas('attribute', function ($q) {
                    $q->where('slug', 'mileage');
                })->where('value', '<=', $this->maxMileage);
            });
        }

        // Featured filter
        if ($this->featuredOnly) {
            $query->where('featured', true);
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.car-listings', [
            'cars' => $this->filteredCars,
        ]);
    }
}