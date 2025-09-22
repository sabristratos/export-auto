<!-- Featured Cars Section -->
<section id="cars" class="section-standard bg-white">
    <div class="container-public">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <!-- Luxury Badge/Tagline -->
            <div class="flex items-center justify-center mb-6 space-x-4 luxury-slide-in">
                <div class="w-8 h-[1px] bg-neutral-300"></div>
                <span class="text-neutral-600 text-sm tracking-[0.2em] uppercase font-helvetica font-light">
                    {{ __('Premium Collection') }}
                </span>
                <div class="w-8 h-[1px] bg-neutral-300"></div>
            </div>

            <!-- Main Title -->
            <h2 class="text-4xl md:text-5xl xl:text-6xl font-light text-neutral-900 font-helvetica mb-6 luxury-fade-in">
                {{ __('Featured') }} <span class="font-semibold">{{ __('Vehicles') }}</span>
            </h2>

            <!-- Description -->
            <p class="text-xl text-neutral-700 font-helvetica font-light leading-relaxed container-text luxury-fade-in">
                {{ __('Discover our handpicked selection of premium automobiles, each representing the pinnacle of luxury, performance, and craftsmanship.') }}
            </p>
        </div>

        <!-- Cars Grid -->
        <livewire:featured-cars />

        <!-- Call to Action -->
        <div class="text-center mt-12 luxury-fade-in">
            <x-keys::button
                variant="outline"
                size="lg"
                href="{{ route('cars.index') }}"
                class="px-12">
                {{ __('View All Vehicles') }}
            </x-keys::button>
        </div>
    </div>
</section>