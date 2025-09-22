@php
    // Get stats for banner
    $totalCars = \App\Models\Car::published()->count();
    $totalMakes = \App\Models\Car::published()->distinct('make_id')->count('make_id');
    $featuredCars = \App\Models\Car::published()->where('featured', true)->count();

    $bannerStats = [
        [
            'icon' => 'heroicon-o-rectangle-stack',
            'value' => $totalCars,
            'label' => __('Available Cars')
        ],
        [
            'icon' => 'heroicon-o-star',
            'value' => $totalMakes,
            'label' => __('Premium Brands')
        ],
        [
            'icon' => 'heroicon-o-bolt',
            'value' => $featuredCars,
            'label' => __('Featured Cars')
        ],
        [
            'icon' => 'heroicon-o-phone',
            'value' => '24/7',
            'label' => __('Support Available')
        ]
    ];
@endphp

<x-layouts.app :headerVariant="'overlay'">
    <x-slot:title>{{ __('Car Listings') }} - {{ setting('site_name', 'Elite Car Export') }}</x-slot:title>

    <!-- Page Banner -->
    <x-page-banner
        :title="__('Browse Our Collection')"
        :description="__('Discover premium vehicles from our curated selection of luxury cars ready for export')"
        :stats="$bannerStats"
    />

    <livewire:car-listings />
</x-layouts.app>