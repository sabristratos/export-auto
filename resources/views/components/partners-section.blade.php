@props([
    'class' => ''
])

<!-- Luxury Partners Section -->
<section class="py-24 lg:py-32 bg-white relative overflow-hidden {{ $class }}">
    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 opacity-[0.015]">
        <div class="absolute top-32 left-32 w-64 h-64 border border-neutral-300 rounded-full"></div>
        <div class="absolute bottom-32 right-32 w-48 h-48 border-2 border-neutral-200 rounded-full"></div>
    </div>

    <div class="max-w-8xl mx-auto px-6 lg:px-24 relative z-10">
        @php
            $partners = \App\Models\Make::active()
                ->ordered()
                ->whereHas('media', function ($query) {
                    $query->where('collection_name', 'logo');
                })
                ->get();
        @endphp

        @if($partners->count() > 0)
            <!-- Asymmetric Layout: Logos Left, Content Right -->
            <div class="lg:grid lg:grid-cols-5 lg:gap-16 lg:items-center">
                <!-- Left Side: Logo Showcase (3 columns) -->
                <div class="lg:col-span-3 mb-16 lg:mb-0 relative">
                    <!-- Row 1: 3 Premium Logos -->
                    <div class="flex justify-between items-center mb-12 luxury-fade-in" style="animation-delay: 0.1s;">
                        @foreach($partners->take(3) as $partner)
                            <div class="flex-1 flex justify-center">
                                <x-partner-logo :make="$partner" class="max-w-24 lg:max-w-32" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Row 2: 2 Center Logos -->
                    <div class="flex justify-center space-x-16 lg:space-x-24 mb-12 luxury-fade-in" style="animation-delay: 0.2s;">
                        @foreach($partners->skip(3)->take(2) as $partner)
                            <div class="flex justify-center">
                                <x-partner-logo :make="$partner" class="max-w-24 lg:max-w-32" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Row 3: 3 Logos with Edge Fade -->
                    <div class="flex justify-between items-center luxury-fade-in" style="animation-delay: 0.3s;">
                        @foreach($partners->skip(5)->take(3) as $partner)
                            <div class="flex-1 flex justify-center">
                                <x-partner-logo :make="$partner" class="max-w-24 lg:max-w-32" />
                            </div>
                        @endforeach
                    </div>

                    <!-- White Gradient Overlays for Edge Fade Effect -->
                    <div class="absolute inset-0 pointer-events-none">
                        <!-- Left edge fade -->
                        <div class="absolute left-0 top-0 bottom-0 w-32 lg:w-48 bg-gradient-to-r from-white to-transparent"></div>
                        <!-- Right edge fade -->
                        <div class="absolute right-0 top-0 bottom-0 w-32 lg:w-48 bg-gradient-to-l from-white to-transparent"></div>
                    </div>
                </div>

                <!-- Right Side: Content Section (2 columns) -->
                <div class="lg:col-span-2 luxury-fade-in" style="animation-delay: 0.4s;">
                    <!-- Section Header -->
                    <x-decorated-heading
                        :overline="__('export.partners.overline')"
                        :heading="__('export.partners.heading')"
                        :description="__('export.partners.description')"
                        alignment="left"
                        class="mb-12"
                    />

                    <!-- Partners Stats -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                            <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                            <span class="text-lg font-light">{{ $partners->count() }}+ {{ __('export.partners.trusted_brands') }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                            <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                            <span class="text-lg font-light">{{ __('export.partners.worldwide_network') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No partners state -->
            <div class="text-center py-16">
                <div class="text-neutral-400 font-helvetica font-light text-lg">
                    {{ __('export.partners.no_partners') }}
                </div>
            </div>
        @endif
    </div>
</section>