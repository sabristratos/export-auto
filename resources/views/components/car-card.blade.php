@props(['car'])

@php
    $photo = $car->getFirstMediaUrl('photos');
    $fallbackPhoto = 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0';

    // Get brand logo
    $logoUrl = $car->make->getLogoUrl();
    $hasLogo = $car->make->hasLogo();

    // Get key attributes
    $year = $car->attributes->where('attribute.slug', 'year')->first()?->value;
    $mileage = $car->attributes->where('attribute.slug', 'mileage')->first()?->value;
    $fuelType = $car->attributes->where('attribute.slug', 'fuel_type')->first()?->value;
    $transmission = $car->attributes->where('attribute.slug', 'transmission')->first()?->value;
    $enginePower = $car->attributes->where('attribute.slug', 'engine_power')->first()?->value;
    $color = $car->attributes->where('attribute.slug', 'color')->first()?->value;
    $doors = $car->attributes->where('attribute.slug', 'doors')->first()?->value;
    $airConditioning = $car->attributes->where('attribute.slug', 'air_conditioning')->first()?->value;
    $navigation = $car->attributes->where('attribute.slug', 'navigation')->first()?->value;
    $leatherSeats = $car->attributes->where('attribute.slug', 'leather_seats')->first()?->value;

    // Format values
    $formattedMileage = $mileage ? number_format($mileage) . ' km' : '';
    $formattedPower = $enginePower ? $enginePower . ' HP' : '';
    $formattedDoors = $doors ? $doors . ' Doors' : '';
@endphp

<!-- Luxury Car Card -->
<x-keys::card class="group overflow-hidden transition-all duration-700 ease-out hover:-translate-y-2 hover:shadow-2xl hover:shadow-black/10 luxury-fade-in" padding="none">
    <!-- Car Photo Container -->
    <div class="relative overflow-hidden bg-neutral-100">
        <!-- Main Photo -->
        <img src="{{ $photo ?: $fallbackPhoto }}"
             alt="{{ $car->make->name }} {{ $car->model->name }}"
             class="w-full h-80 md:h-72 object-cover transition-transform duration-700 group-hover:scale-105">

        <!-- Elegant Overlay on Hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>


        <!-- Price Badge -->
        <div class="absolute top-4 right-4">
            <x-keys::badge variant="solid" color="dark" size="md">
                €{{ number_format($car->price) }}
            </x-keys::badge>
        </div>

    </div>

    <!-- Card Content -->
    <div class="p-4">
        <!-- Make & Model with Logo -->
        <div class="mb-4">
            <!-- Make and Logo -->
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-2xl font-light text-neutral-900 font-helvetica">
                    {{ $car->make->name }}
                </h3>
                @if($hasLogo)
                    <img src="{{ $logoUrl }}"
                         alt="{{ $car->make->name }} logo"
                         class="h-8 w-auto object-contain opacity-80"
                         onerror="this.style.display='none'">
                @endif
            </div>

            <!-- Model -->
            <p class="text-xl font-semibold text-neutral-800 font-helvetica">
                {{ $car->model->name }}
            </p>
        </div>

        <!-- Key Specifications -->
        <div class="mb-4">
            <!-- Primary Details -->
            <div class="flex flex-wrap justify-between gap-4">
                @if($year)
                    <div class="flex items-start gap-2 whitespace-nowrap">
                        <x-keys::icon name="heroicon-o-calendar-days" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Year</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $year }}</div>
                        </div>
                    </div>
                @endif

                @if($formattedMileage)
                    <div class="flex items-start gap-2 whitespace-nowrap">
                        <x-keys::icon name="heroicon-o-calculator" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Mileage</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $formattedMileage }}</div>
                        </div>
                    </div>
                @endif

                @if($formattedPower)
                    <div class="flex items-start gap-2 whitespace-nowrap">
                        <x-keys::icon name="heroicon-o-bolt" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Power</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $formattedPower }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Features -->
            @php
                $badges = [];

                // Add fuel type badge first (priority)
                if($fuelType) {
                    $fuelBadgeColor = match(strtolower($fuelType)) {
                        'electric' => 'success',
                        'hybrid', 'plug-in hybrid' => 'info',
                        'diesel' => 'neutral',
                        'gasoline' => 'warning',
                        default => 'neutral'
                    };
                    $fuelIcon = match(strtolower($fuelType)) {
                        'electric' => 'heroicon-o-bolt',
                        'hybrid', 'plug-in hybrid' => 'heroicon-o-battery-100',
                        'diesel', 'gasoline' => 'heroicon-o-beaker',
                        default => 'heroicon-o-beaker'
                    };
                    $badges[] = [
                        'label' => $fuelType,
                        'icon' => $fuelIcon,
                        'variant' => 'solid',
                        'color' => $fuelBadgeColor
                    ];
                }

                // Add other feature badges
                if($airConditioning) {
                    $badges[] = [
                        'label' => 'A/C',
                        'icon' => 'heroicon-o-cloud',
                        'variant' => 'simple',
                        'color' => 'neutral'
                    ];
                }

                if($navigation) {
                    $badges[] = [
                        'label' => 'Navigation',
                        'icon' => 'heroicon-o-map-pin',
                        'variant' => 'simple',
                        'color' => 'neutral'
                    ];
                }

                if($leatherSeats) {
                    $badges[] = [
                        'label' => 'Leather',
                        'icon' => 'heroicon-o-squares-2x2',
                        'variant' => 'simple',
                        'color' => 'neutral'
                    ];
                }

                // Add transmission badge
                if($transmission) {
                    $badges[] = [
                        'label' => $transmission,
                        'icon' => 'heroicon-o-cog-6-tooth',
                        'variant' => 'simple',
                        'color' => 'neutral'
                    ];
                }

                // Add color badge
                if($color) {
                    $badges[] = [
                        'label' => $color,
                        'icon' => 'heroicon-o-swatch',
                        'variant' => 'simple',
                        'color' => 'neutral'
                    ];
                }

                $maxBadges = 6;
                $visibleBadges = array_slice($badges, 0, $maxBadges - 1);
                $hasMoreBadges = count($badges) > $maxBadges - 1;
            @endphp

            @if(count($badges) > 0)
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($visibleBadges as $badge)
                        <x-keys::badge variant="{{ $badge['variant'] }}" color="{{ $badge['color'] }}" size="xs">
                            <x-keys::icon name="{{ $badge['icon'] }}" size="xs" class="mr-1" />
                            {{ $badge['label'] }}
                        </x-keys::badge>
                    @endforeach

                    @if($hasMoreBadges)
                        <x-keys::badge variant="simple" color="neutral" size="xs">
                            <x-keys::icon name="heroicon-o-ellipsis-horizontal" size="xs" class="mr-1" />
                            +{{ count($badges) - count($visibleBadges) }} more
                        </x-keys::badge>
                    @endif
                </div>
            @endif
        </div>

        <!-- Description -->
        @if($car->description)
            <p class="text-neutral-700 text-sm leading-relaxed mb-6 line-clamp-2">
                {{ $car->description }}
            </p>
        @endif

        <!-- Action Button -->
        <div>
            <x-keys::button
                variant="brand"
                size="sm"
                href="{{ route('cars.show', $car->slug) }}"
                class="w-full justify-center">
                View Details
            </x-keys::button>
        </div>
    </div>
</x-keys::card>
