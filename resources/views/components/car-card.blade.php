@props(['car'])

@php
    $photo = $car->getFirstMediaUrl('photos');
    $fallbackPhoto = 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0';

    // Get brand logo
    $logoUrl = $car->make->getLogoUrl('thumb');
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
            <x-keys::badge variant="solid" color="neutral" size="md">
                €{{ number_format($car->price) }}
            </x-keys::badge>
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-6">
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
            <div class="flex justify-between gap-4 mb-4">
                @if($year)
                    <div class="flex items-start gap-2 flex-1">
                        <x-keys::icon name="heroicon-o-calendar-days" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Year</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $year }}</div>
                        </div>
                    </div>
                @endif

                @if($formattedMileage)
                    <div class="flex items-start gap-2 flex-1">
                        <x-keys::icon name="heroicon-o-calculator" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Mileage</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $formattedMileage }}</div>
                        </div>
                    </div>
                @endif

                @if($formattedPower)
                    <div class="flex items-start gap-2 flex-1">
                        <x-keys::icon name="heroicon-o-bolt" size="sm" class="text-neutral-500 mt-0.5" />
                        <div>
                            <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">Power</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $formattedPower }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Secondary Details -->
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-neutral-600">
                @if($fuelType)
                    <span class="flex items-center">
                        <x-keys::icon name="heroicon-o-beaker" size="xs" class="mr-1" />
                        {{ $fuelType }}
                    </span>
                @endif

                @if($transmission)
                    <span class="flex items-center">
                        <x-keys::icon name="heroicon-o-cog-6-tooth" size="xs" class="mr-1" />
                        {{ $transmission }}
                    </span>
                @endif

                @if($color)
                    <span class="flex items-center">
                        <x-keys::icon name="heroicon-o-swatch" size="xs" class="mr-1" />
                        {{ $color }}
                    </span>
                @endif

                @if($formattedDoors)
                    <span class="flex items-center">
                        <x-keys::icon name="heroicon-o-home" size="xs" class="mr-1" />
                        {{ $formattedDoors }}
                    </span>
                @endif
            </div>

            <!-- Features -->
            @if($airConditioning || $navigation || $leatherSeats)
                <div class="flex flex-wrap gap-2 mt-4">
                    @if($airConditioning)
                        <x-keys::badge variant="simple" color="neutral" size="xs">
                            <x-keys::icon name="heroicon-o-cloud" size="xs" class="mr-1" />
                            A/C
                        </x-keys::badge>
                    @endif

                    @if($navigation)
                        <x-keys::badge variant="simple" color="neutral" size="xs">
                            <x-keys::icon name="heroicon-o-map-pin" size="xs" class="mr-1" />
                            Navigation
                        </x-keys::badge>
                    @endif

                    @if($leatherSeats)
                        <x-keys::badge variant="simple" color="neutral" size="xs">
                            <x-keys::icon name="heroicon-o-squares-2x2" size="xs" class="mr-1" />
                            Leather
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

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <x-keys::button
                variant="outline"
                size="sm"
                href="/cars/{{ $car->slug }}"
                class="flex-1 justify-center">
                View Details
            </x-keys::button>

            <x-keys::button
                variant="brand"
                size="sm"
                href="/cars/{{ $car->slug }}#inquire"
                class="flex-1 justify-center">
                Inquire
            </x-keys::button>
        </div>
    </div>
</x-keys::card>
