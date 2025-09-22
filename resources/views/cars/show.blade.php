<x-layouts.app>
    <x-slot:title>{{ $car->make->name }} {{ $car->model->name }} - {{ setting('site_name', 'Elite Car Export') }}</x-slot:title>
    <x-slot:headerVariant>standard</x-slot:headerVariant>

    @php
        // Get brand logo
        $logoUrl = $car->make->getLogoUrl();
        $hasLogo = $car->make->hasLogo();

        // Get key attributes
        $year = $car->attributes->where('attribute.slug', 'year')->first()?->value;
        $mileage = $car->attributes->where('attribute.slug', 'mileage')->first()?->value;
        $fuelType = $car->attributes->where('attribute.slug', 'fuel_type')->first()?->value;
        $transmission = $car->attributes->where('attribute.slug', 'transmission')->first()?->value;
        $enginePower = $car->attributes->where('attribute.slug', 'engine_power')->first()?->value;
        $engineSize = $car->attributes->where('attribute.slug', 'engine_size')->first()?->value;
        $color = $car->attributes->where('attribute.slug', 'color')->first()?->value;
        $doors = $car->attributes->where('attribute.slug', 'doors')->first()?->value;
        $seats = $car->attributes->where('attribute.slug', 'seats')->first()?->value;
        $airConditioning = $car->attributes->where('attribute.slug', 'air_conditioning')->first()?->value;
        $navigation = $car->attributes->where('attribute.slug', 'navigation')->first()?->value;
        $leatherSeats = $car->attributes->where('attribute.slug', 'leather_seats')->first()?->value;
        $sunroof = $car->attributes->where('attribute.slug', 'sunroof')->first()?->value;
        $electricWindows = $car->attributes->where('attribute.slug', 'electric_windows')->first()?->value;
        $abs = $car->attributes->where('attribute.slug', 'abs')->first()?->value;
        $airbags = $car->attributes->where('attribute.slug', 'airbags')->first()?->value;
        $parkingSensors = $car->attributes->where('attribute.slug', 'parking_sensors')->first()?->value;

        // Format values
        $formattedMileage = $mileage ? number_format($mileage) . ' ' . __('km') : '';
        $formattedPower = $enginePower ? $enginePower . ' ' . __('HP') : '';
        $formattedEngine = $engineSize ? $engineSize . __('L') : '';
        $formattedDoors = $doors ? $doors . ' ' . __('Doors') : '';
        $formattedSeats = $seats ? $seats . ' ' . __('Seats') : '';

        // Get all car photos using Spatie Media Library
        $photos = $car->getMedia('photos');
        $galleryPhotos = $car->getMedia('gallery');
        $allPhotos = $photos->merge($galleryPhotos);

        // Get main photo with proper Spatie Media Library usage
        $mainPhoto = $car->getFirstMediaUrl('photos', 'large');
        if (!$mainPhoto) {
            $mainPhoto = $car->getFirstMediaUrl('photos'); // Fallback to original
        }
        if (!$mainPhoto) {
            $mainPhoto = 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=1200&auto=format&fit=crop'; // Final fallback
        }
    @endphp

    <!-- Hero Section -->
    <div class="bg-white">
        <div class="container-public py-8">
            <!-- Breadcrumb -->
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-neutral-500 hover:text-neutral-900">{{ __('Home') }}</a></li>
                    <li class="text-neutral-400">/</li>
                    <li><a href="{{ route('cars.index', ['make' => $car->make->slug]) }}" class="text-neutral-500 hover:text-neutral-900">{{ $car->make->name }}</a></li>
                    <li class="text-neutral-400">/</li>
                    <li class="text-neutral-900 font-medium">{{ $car->model->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Car Details -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Car Images -->
                    <div class="space-y-4">
                        <!-- Main Image with Overlay -->
                        <div class="aspect-w-16 aspect-h-12 bg-neutral-100 rounded-lg overflow-hidden relative">
                            <img src="{{ $mainPhoto }}"
                                 alt="{{ $car->make->name }} {{ $car->model->name }}"
                                 class="w-full h-96 object-cover">

                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                            <!-- Car Name and Price Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <div class="flex items-end justify-between">
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <h1 class="text-2xl font-light">{{ $car->make->name }}</h1>
                                            <h2 class="text-xl font-semibold">{{ $car->model->name }}</h2>
                                        </div>
                                        @if($hasLogo)
                                            <img src="{{ $logoUrl }}"
                                                 alt="{{ $car->make->name }} logo"
                                                 class="h-10 w-auto object-contain opacity-90">
                                        @endif
                                    </div>
                                    <div class="text-2xl font-bold">€{{ number_format($car->price) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Thumbnails -->
                        @if($allPhotos->count() > 1)
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($allPhotos->take(4) as $photo)
                                    <div class="aspect-w-4 aspect-h-3 bg-neutral-100 rounded-md overflow-hidden cursor-pointer hover:opacity-75 transition-opacity">
                                        <img src="{{ $photo->getUrl('preview') ?: $photo->getUrl() }}"
                                             alt="Gallery image"
                                             class="w-full h-24 object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Key Specifications Grid -->
                    <div class="bg-neutral-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">{{ __('Key Specifications') }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Make -->
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                @if($hasLogo)
                                    <img src="{{ $logoUrl }}"
                                         alt="{{ $car->make->name }} logo"
                                         class="w-5 h-5 object-contain opacity-70 filter grayscale">
                                @else
                                    <x-keys::icon name="heroicon-o-cube-transparent" size="sm" class="text-neutral-500" />
                                @endif
                                <div>
                                    <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Make') }}</div>
                                    <div class="font-semibold text-neutral-900">{{ $car->make->name }}</div>
                                </div>
                            </div>

                            @if($year)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Year') }}</div>
                                        <div class="font-semibold text-neutral-900">{{ $year }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($formattedMileage)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Mileage') }}</div>
                                        <div class="font-semibold text-neutral-900">{{ $formattedMileage }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($formattedPower)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Power') }}</div>
                                        <div class="font-semibold text-neutral-900">{{ $formattedPower }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($fuelType)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    @php
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
                                    @endphp
                                    <x-keys::icon :name="$fuelIcon" size="sm" class="text-neutral-500" />
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Fuel Type') }}</div>
                                        <div class="flex items-center gap-2">
                                            <div class="font-semibold text-neutral-900">{{ $fuelType }}</div>
                                            <x-keys::badge variant="solid" :color="$fuelBadgeColor" size="xs">
                                                {{ strtoupper(substr($fuelType, 0, 1)) }}
                                            </x-keys::badge>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($transmission)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Transmission') }}</div>
                                        <div class="font-semibold text-neutral-900">{{ $transmission }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($color)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-neutral-500 uppercase tracking-wide">{{ __('Color') }}</div>
                                        <div class="font-semibold text-neutral-900">{{ $color }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        @if($formattedDoors)
                            <div class="flex justify-between">
                                <span class="text-neutral-600">{{ __('Doors:') }}</span>
                                <span class="font-medium">{{ $formattedDoors }}</span>
                            </div>
                        @endif
                        @if($formattedSeats)
                            <div class="flex justify-between">
                                <span class="text-neutral-600">{{ __('Seats:') }}</span>
                                <span class="font-medium">{{ $formattedSeats }}</span>
                            </div>
                        @endif
                        @if($formattedEngine)
                            <div class="flex justify-between">
                                <span class="text-neutral-600">{{ __('Engine Size:') }}</span>
                                <span class="font-medium">{{ $formattedEngine }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Features -->
                    @if($airConditioning || $navigation || $leatherSeats || $sunroof || $electricWindows || $abs || $airbags || $parkingSensors)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-3">{{ __('Features & Equipment') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($airConditioning)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Air Conditioning') }}
                                    </x-keys::badge>
                                @endif
                                @if($navigation)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Navigation System') }}
                                    </x-keys::badge>
                                @endif
                                @if($leatherSeats)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Leather Seats') }}
                                    </x-keys::badge>
                                @endif
                                @if($sunroof)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Sunroof') }}
                                    </x-keys::badge>
                                @endif
                                @if($electricWindows)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Electric Windows') }}
                                    </x-keys::badge>
                                @endif
                                @if($abs)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('ABS') }}
                                    </x-keys::badge>
                                @endif
                                @if($airbags)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Airbags') }}
                                    </x-keys::badge>
                                @endif
                                @if($parkingSensors)
                                    <x-keys::badge variant="simple" color="neutral" size="sm">
                                        {{ __('Parking Sensors') }}
                                    </x-keys::badge>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($car->description)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-3">{{ __('Description') }}</h3>
                            <p class="text-neutral-700 leading-relaxed">{{ $car->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Sticky Inquiry Form -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <livewire:car-inquiry-form :car="$car" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Cars -->
    <div class="bg-white py-16">
        <div class="container-public">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 mb-4">{{ __('You Might Also Like') }}</h2>
                <p class="text-neutral-600">{{ __('Discover other premium vehicles from our collection') }}</p>
            </div>

            @php
                // Smart related cars algorithm with fallbacks
                $relatedCars = collect();

                // First: Try same make cars
                $sameMakeCars = App\Models\Car::published()
                    ->where('make_id', $car->make_id)
                    ->where('id', '!=', $car->id)
                    ->with(['make', 'model', 'attributes.attribute'])
                    ->limit(3)
                    ->get();

                if ($sameMakeCars->count() >= 3) {
                    $relatedCars = $sameMakeCars;
                } else {
                    // Add same make cars if any
                    $relatedCars = $relatedCars->merge($sameMakeCars);
                    $needed = 3 - $relatedCars->count();

                    if ($needed > 0) {
                        // Second: Try featured cars from any make
                        $featuredCars = App\Models\Car::published()
                            ->where('featured', true)
                            ->where('id', '!=', $car->id)
                            ->whereNotIn('id', $relatedCars->pluck('id'))
                            ->with(['make', 'model', 'attributes.attribute'])
                            ->limit($needed)
                            ->get();

                        $relatedCars = $relatedCars->merge($featuredCars);
                        $needed = 3 - $relatedCars->count();

                        if ($needed > 0) {
                            // Third: Get random published cars
                            $randomCars = App\Models\Car::published()
                                ->where('id', '!=', $car->id)
                                ->whereNotIn('id', $relatedCars->pluck('id'))
                                ->with(['make', 'model', 'attributes.attribute'])
                                ->inRandomOrder()
                                ->limit($needed)
                                ->get();

                            $relatedCars = $relatedCars->merge($randomCars);
                        }
                    }
                }

                // Take only 3 cars
                $relatedCars = $relatedCars->take(3);
            @endphp

            @if($relatedCars->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedCars as $relatedCar)
                        <x-car-card :car="$relatedCar" />
                    @endforeach
                </div>
            @else
                <div class="text-center text-neutral-500">
                    <p>{{ __('More vehicles will be available soon.') }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Customer Reviews Section - Generic -->
    @php
        // Get general website reviews instead of car-specific ones
        $allReviews = App\Models\Review::with('car.make', 'car.model')
            ->latest()
            ->limit(8)
            ->get();

        // Calculate stats
        $totalReviews = $allReviews->count();
        $averageRating = $totalReviews > 0 ? $allReviews->avg('rating') : 0;
        $satisfactionRate = $totalReviews > 0 ? round(($allReviews->where('rating', '>=', 4)->count() / $totalReviews) * 100) : 0;
    @endphp

    @if($allReviews->count() > 0)
        <section class="bg-neutral-50 py-16 relative overflow-hidden">
            <!-- Subtle Background Elements -->
            <div class="absolute inset-0 opacity-[0.015]">
                <div class="absolute top-32 right-32 w-64 h-64 border border-neutral-300 rounded-full"></div>
                <div class="absolute bottom-32 left-32 w-48 h-48 border-2 border-neutral-200 rounded-full"></div>
            </div>

            <div class="container-public relative z-10">
                <!-- Two Column Layout -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:items-center">
                    <!-- Left Column: Content & Stats -->
                    <div class="mb-16 lg:mb-0">
                        <!-- Section Header -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-[1px] bg-neutral-400"></div>
                                <span class="ml-4 text-sm tracking-[0.2em] uppercase font-helvetica font-light text-neutral-600">
                                    {{ __('Customer Reviews') }}
                                </span>
                            </div>
                            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4 font-helvetica">
                                {{ __('What Our Clients Say') }}
                            </h2>
                            <p class="text-lg text-neutral-600 font-helvetica font-light leading-relaxed">
                                {{ __('Read testimonials from satisfied customers who have successfully exported their dream cars with us') }}
                            </p>
                        </div>

                        <!-- Review Stats -->
                        <div class="space-y-6 mb-12">
                            <!-- Average Rating -->
                            <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                                <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                                <div class="text-2xl font-helvetica font-bold text-brand-600">
                                    {{ number_format($averageRating, 1) }}
                                </div>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $averageRating)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-neutral-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-lg font-light">{{ __('Average Rating') }}</span>
                            </div>

                            <!-- Review Count -->
                            <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                                <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                                <div class="text-2xl font-helvetica font-bold text-brand-600">
                                    {{ $totalReviews }}+
                                </div>
                                <span class="text-lg font-light">{{ __('Customer Reviews') }}</span>
                            </div>

                            <!-- Satisfaction Rate -->
                            <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                                <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                                <div class="text-2xl font-helvetica font-bold text-brand-600">
                                    {{ $satisfactionRate }}%
                                </div>
                                <span class="text-lg font-light">{{ __('Satisfaction Rate') }}</span>
                            </div>
                        </div>

                        <!-- Write Review Button -->
                        <div>
                            <x-keys::button
                                variant="brand"
                                size="lg"
                                href="{{ route('contact') }}"
                                class="w-full lg:w-auto px-8 py-4"
                            >
                                {{ __('Share Your Experience') }}
                            </x-keys::button>
                        </div>
                    </div>

                    <!-- Right Column: Reviews Carousel -->
                    <div>
                        <x-review-carousel :reviews="$allReviews" />
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
