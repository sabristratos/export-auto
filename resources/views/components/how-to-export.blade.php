@props([
    'class' => ''
])

<!-- How to Export Your Dream Car Section -->
<section class="py-24 lg:py-40 bg-gradient-to-b from-neutral-50 via-white to-neutral-50 relative overflow-hidden {{ $class }}">
    <!-- Luxury Background Elements -->
    <div class="absolute inset-0 opacity-[0.02]">
        <div class="absolute top-20 right-20 w-72 h-72 border border-neutral-400 rounded-full"></div>
        <div class="absolute bottom-40 left-20 w-48 h-48 border-2 border-neutral-300 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-neutral-200 rounded-full"></div>
    </div>

    <div class="max-w-8xl mx-auto px-6 lg:px-24 relative z-10">
        <!-- Section Header with Luxury Styling -->
        <x-decorated-heading
            :overline="__('export.how_to_export.overline')"
            :heading="__('export.how_to_export.heading')"
            :description="__('export.how_to_export.description')"
            alignment="center"
            class="mb-28 luxury-fade-in"
        />

        <!-- Export Process Steps Grid with Luxury Animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 mb-32">
            @php
                $steps = __('export.how_to_export.steps');
            @endphp

            @if(is_array($steps))
                @foreach($steps as $key => $step)
                    <x-export-step-card
                        :step="$loop->iteration"
                        :title="$step['title']"
                        :description="$step['description']"
                        :icon="$step['icon']"
                        class="luxury-fade-in"
                        style="animation-delay: {{ ($loop->iteration - 1) * 0.2 }}s;"
                    />
                @endforeach
            @else
                {{-- Fallback: Manual step definition with animations --}}
                <x-export-step-card
                    step="1"
                    :title="__('export.how_to_export.steps.find_select.title')"
                    :description="__('export.how_to_export.steps.find_select.description')"
                    icon="search"
                    class="luxury-fade-in"
                    style="animation-delay: 0s;"
                />
                <x-export-step-card
                    step="2"
                    :title="__('export.how_to_export.steps.documentation.title')"
                    :description="__('export.how_to_export.steps.documentation.description')"
                    icon="document"
                    class="luxury-fade-in"
                    style="animation-delay: 0.2s;"
                />
                <x-export-step-card
                    step="3"
                    :title="__('export.how_to_export.steps.shipping.title')"
                    :description="__('export.how_to_export.steps.shipping.description')"
                    icon="shipping"
                    class="luxury-fade-in"
                    style="animation-delay: 0.4s;"
                />
                <x-export-step-card
                    step="4"
                    :title="__('export.how_to_export.steps.delivery.title')"
                    :description="__('export.how_to_export.steps.delivery.description')"
                    icon="delivery"
                    class="luxury-fade-in"
                    style="animation-delay: 0.6s;"
                />
            @endif
        </div>

        <!-- Luxury Call to Action Section -->
        <div class="text-center bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 rounded-3xl p-16 lg:p-24 relative overflow-hidden luxury-fade-in" style="animation-delay: 0.8s;">
            <!-- Sophisticated Background Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/10"></div>

            <!-- Luxury Geometric Elements -->
            <div class="absolute inset-0 opacity-[0.03]">
                <div class="absolute top-0 left-0 w-40 h-40 border border-white rounded-full transform -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 border border-white rounded-full transform translate-x-1/3 translate-y-1/3"></div>
                <div class="absolute top-1/2 left-1/2 w-32 h-32 border border-white transform -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
                <!-- Additional luxury accents -->
                <div class="absolute top-1/4 right-1/4 w-16 h-16 border border-white/50 rounded-full"></div>
                <div class="absolute bottom-1/4 left-1/4 w-12 h-12 border-2 border-white/30 transform rotate-45"></div>
            </div>

            <!-- Premium Content -->
            <div class="relative z-10 max-w-4xl mx-auto">
                <h3 class="!text-white text-4xl lg:text-5xl xl:text-6xl font-bold mb-8 font-helvetica leading-tight tracking-tight">
                    {{ __('export.how_to_export.cta.title') }}
                </h3>

                <p class="!text-white/80 text-xl lg:text-2xl font-helvetica font-light mb-12 max-w-2xl mx-auto leading-relaxed">
                    {{ __('export.how_to_export.cta.subtitle') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-8 justify-center items-center">
                    <x-custom-button
                        variant="primary"
                        size="lg"
                        href="#contact"
                        class="px-12 py-4"
                    >
                        {{ __('export.how_to_export.cta.button_text') }}
                    </x-custom-button>

                    <x-custom-button
                        variant="secondary"
                        size="lg"
                        href="tel:{{ setting('contact_phone', '+1-555-0123') }}"
                        class="px-12 py-4"
                    >
                        {{ __('export.how_to_export.cta.secondary_button_text') }}
                    </x-custom-button>
                </div>
            </div>

            <!-- Luxury Accent Lines -->
            <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>

            <!-- Corner Accent Elements -->
            <div class="absolute top-8 left-8 w-16 h-16 border-t-2 border-l-2 border-white/20"></div>
            <div class="absolute bottom-8 right-8 w-16 h-16 border-b-2 border-r-2 border-white/20"></div>
        </div>
    </div>

    <!-- Luxury Section Bottom Accent -->
    <div class="mt-32 flex justify-center luxury-fade-in" style="animation-delay: 1s;">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-[2px] bg-gradient-to-r from-transparent to-brand-500"></div>
            <div class="w-3 h-3 bg-brand-600 rounded-full"></div>
            <div class="w-32 h-[2px] bg-gradient-to-r from-brand-500 to-brand-600"></div>
            <div class="w-3 h-3 bg-brand-600 rounded-full"></div>
            <div class="w-16 h-[2px] bg-gradient-to-r from-brand-500 to-transparent"></div>
        </div>
    </div>
</section>