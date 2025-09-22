@props([
    'title' => __('Luxury Car Export Specialists'),
    'description' => __('Premium European and luxury vehicles exported worldwide with unmatched expertise and service'),
    'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7',
    'primaryButtonText' => __('Browse Our Collection'),
    'primaryButtonUrl' => null,
    'secondaryButtonText' => __('Get a Quote'),
    'secondaryButtonUrl' => '#contact',
    'class' => '',
])

@php
    $primaryUrl = $primaryButtonUrl ?: route('cars.index');
    $secondaryUrl = $secondaryButtonUrl ?: '#contact';
@endphp

<!-- Luxury Full-Screen Hero Section -->
<section class="relative h-screen flex items-center overflow-hidden {{ $class }}">
    <!-- Background Image with Luxury Treatment -->
    <img src="{{ $image }}"
         alt="{{ __('Luxury car background') }}"
         class="absolute inset-0 w-full h-full object-cover z-0 scale-105 hero-bg-parallax luxury-scale-in">

    <!-- Sophisticated Gradient Overlay -->
    <div class="absolute inset-0 z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-black/80 to-transparent"></div>
    </div>


    <!-- Premium Content Container -->
    <div class="relative z-20 w-full container-public h-full flex items-center">
        <div class="grid lg:grid-cols-12 gap-8 w-full">
            <!-- Main Hero Content - Asymmetric Layout -->
            <div class="lg:col-span-7 xl:col-span-6 flex flex-col justify-center min-h-[60vh]">
                <!-- Luxury Badge/Tagline -->
                <div class="flex items-center mb-6 space-x-4 luxury-slide-in" style="animation-delay: 0.2s;">
                    <div class="w-8 h-[1px] bg-white/60"></div>
                    <span class="!text-white/80 text-sm tracking-[0.2em] uppercase font-helvetica font-light">
                        {{ __('Premium Export Services') }}
                    </span>
                </div>

                <!-- Main Title with Luxury Typography -->
                <h1 class="!text-white mb-8 font-helvetica leading-[0.9] tracking-tight">
                    <span class="block text-4xl md:text-6xl xl:text-7xl font-light mb-2 luxury-fade-in" style="animation-delay: 0.4s;">
                        {{ __('Luxury Car') }}
                    </span>
                    <span class="block text-5xl md:text-7xl xl:text-8xl font-bold luxury-fade-in" style="animation-delay: 0.6s;">
                        {{ __('Export Specialists') }}
                    </span>
                </h1>

                <!-- Elegant Description -->
                <p class="!text-white/90 text-lg md:text-xl font-helvetica font-light leading-relaxed mb-12 max-w-xl luxury-fade-in" style="animation-delay: 0.8s;">
                    {{ __('Premium European and luxury vehicles exported worldwide with unmatched expertise and service') }}
                </p>

                <!-- Luxury Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 luxury-fade-in" style="animation-delay: 1s;">
                    <x-keys::button variant="brand" size="lg" href="{{ $primaryUrl }}">
                        {{ $primaryButtonText }}
                    </x-keys::button>

                    <x-keys::button variant="outline" class="text-white hover:text-brand" size="lg" href="{{ $secondaryUrl }}">
                        {{ $secondaryButtonText }}
                    </x-keys::button>
                </div>
            </div>

            <!-- Right Side - Luxury Stats/Features (Optional Content Area) -->
            <div class="lg:col-span-5 xl:col-span-6 flex items-end justify-end pb-16">
                <div class="text-right !text-white/70 space-y-6 max-w-sm luxury-fade-in" style="animation-delay: 1.2s;">
                    <!-- Luxury Features/Stats could go here -->
                    <div class="border-t border-white/20 pt-6">
                        <div class="!text-white/70 text-xs tracking-widest uppercase font-helvetica font-light">
                            {{ __('Exporting Since') }}
                        </div>
                        <div class="!text-white text-2xl font-helvetica font-light mt-1">
                            {{ date('Y') - 2010 }}+ {{ __('Years of Excellence') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Luxury Scroll Indicator -->
    <div class="absolute bottom-16 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center !text-white/60">
        <span class="!text-white/60 text-xs tracking-widest uppercase font-helvetica font-light">
            {{ __('Scroll to Discover') }}
        </span>
        <x-scroll-indicator />
    </div>
</section>
