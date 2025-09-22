<!-- Reviews Section -->
<section class="py-24 lg:py-32 bg-neutral-50 relative overflow-hidden">
    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 opacity-[0.015]">
        <div class="absolute top-32 right-32 w-64 h-64 border border-neutral-300 rounded-full"></div>
        <div class="absolute bottom-32 left-32 w-48 h-48 border-2 border-neutral-200 rounded-full"></div>
    </div>

    <div class="max-w-8xl mx-auto px-6 lg:px-24 relative z-10">
        <!-- Two Column Layout -->
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:items-center">
            <!-- Left Column: Content & CTA -->
            <div class="mb-16 lg:mb-0">
                <!-- Section Header -->
                <x-decorated-heading
                    :overline="__('Customer Reviews')"
                    :heading="__('What Our Clients Say')"
                    :description="__('Read testimonials from satisfied customers who have successfully exported their dream cars with us')"
                    alignment="left"
                    class="mb-12 luxury-fade-in"
                />

                <!-- Review Stats -->
                @if($totalReviews > 0)
                    <div class="space-y-6 mb-12 luxury-fade-in" style="animation-delay: 0.2s;">
                        <!-- Average Rating -->
                        <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                            <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                            <div class="text-2xl font-helvetica font-bold text-brand-600">
                                {{ number_format($averageRating, 1) }}
                            </div>
                            <x-star-rating-display :rating="$averageRating" size="sm" />
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
                                {{ $reviews->where('rating', '>=', 4)->count() > 0 ? round(($reviews->where('rating', '>=', 4)->count() / $reviews->count()) * 100) : 0 }}%
                            </div>
                            <span class="text-lg font-light">{{ __('Satisfaction Rate') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Write Review Button -->
                <div class="luxury-fade-in" style="animation-delay: 0.3s;">
                    <x-keys::button
                        variant="brand"
                        size="lg"
                        icon="heroicon-o-star"
                        wire:click="openReviewModal"
                        class="w-full lg:w-auto px-8 py-4"
                    >
                        {{ __('Write a Review') }}
                    </x-keys::button>
                </div>
            </div>

            <!-- Right Column: Reviews Carousel -->
            @if($reviews->count() > 0)
                <div class="luxury-fade-in" style="animation-delay: 0.4s;">
                    <x-review-carousel :reviews="$reviews" />
                </div>
            @else
                <!-- No Reviews State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-helvetica font-semibold text-neutral-900 mb-2">
                            {{ __('No Reviews Yet') }}
                        </h3>
                    </div>
                </div>
            @endif
        </div>

        <!-- Review Form Modal -->
        <livewire:review-form />
    </div>
</section>
