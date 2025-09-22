@props([
    'class' => ''
])

<!-- Reviews Section -->
<section class="py-24 lg:py-32 bg-neutral-50 relative overflow-hidden {{ $class }}">
    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 opacity-[0.015]">
        <div class="absolute top-32 right-32 w-64 h-64 border border-neutral-300 rounded-full"></div>
        <div class="absolute bottom-32 left-32 w-48 h-48 border-2 border-neutral-200 rounded-full"></div>
    </div>

    <div class="max-w-8xl mx-auto px-6 lg:px-24 relative z-10">
        @php
            $reviews = \App\Models\Review::approved()
                ->latest()
                ->limit(6)
                ->get();
            $averageRating = $reviews->avg('rating') ?? 0;
            $totalReviews = \App\Models\Review::approved()->count();
        @endphp

        <!-- Centered Section Header -->
        <div class="text-center luxury-fade-in mb-16">
            <x-decorated-heading
                :overline="__('export.reviews.overline')"
                :heading="__('export.reviews.heading')"
                :description="__('export.reviews.description')"
                alignment="center"
                class="mb-12"
            />

            <!-- Write Review Button -->
            <div class="luxury-fade-in" style="animation-delay: 0.3s;">
                <x-keys::button
                    variant="brand"
                    size="lg"
                    icon="heroicon-o-star"
                    onclick="document.querySelector('[data-modal=review-modal]').click()"
                    class="px-8 py-4"
                >
                    {{ __('export.reviews.form.write_review_button') }}
                </x-keys::button>
            </div>
        </div>

        <!-- Review Stats Grid -->
        @if($totalReviews > 0)
            <div class="grid md:grid-cols-3 gap-8 mb-24 luxury-fade-in" style="animation-delay: 0.4s;">
                <!-- Average Rating -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-neutral-200/50 text-center">
                    <h4 class="text-lg font-helvetica font-semibold text-neutral-900 mb-4">
                        {{ __('export.reviews.stats.average_rating') }}
                    </h4>
                    <span class="text-3xl font-helvetica font-bold text-brand-600 block mb-3">
                        {{ number_format($averageRating, 1) }}
                    </span>
                    <x-star-rating-display :rating="$averageRating" size="md" class="justify-center" />
                </div>

                <!-- Review Count -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-neutral-200/50 text-center">
                    <h4 class="text-lg font-helvetica font-semibold text-neutral-900 mb-4">
                        {{ __('export.reviews.stats.reviews_count') }}
                    </h4>
                    <span class="text-3xl font-helvetica font-bold text-brand-600">
                        {{ $totalReviews }}+
                    </span>
                </div>

                <!-- Satisfaction Rate -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-neutral-200/50 text-center">
                    <h4 class="text-lg font-helvetica font-semibold text-neutral-900 mb-4">
                        {{ __('export.reviews.stats.satisfaction_rate') }}
                    </h4>
                    <span class="text-3xl font-helvetica font-bold text-brand-600">
                        {{ $reviews->where('rating', '>=', 4)->count() > 0 ? round(($reviews->where('rating', '>=', 4)->count() / $reviews->count()) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        @endif

        <!-- Review Form Modal -->
        <livewire:review-form />

        @if($reviews->count() > 0)
            <!-- Reviews Display Section -->
            <div class="mt-24">
                <!-- Section Divider -->
                <div class="flex items-center justify-center mb-16">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-[2px] bg-gradient-to-r from-transparent to-brand-500"></div>
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="w-24 h-[2px] bg-gradient-to-r from-brand-500 to-brand-600"></div>
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="w-12 h-[2px] bg-gradient-to-r from-brand-500 to-transparent"></div>
                    </div>
                </div>

                <!-- Reviews Grid -->
                <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                    @foreach($reviews as $review)
                        <div class="luxury-fade-in" style="animation-delay: {{ $loop->index * 0.1 + 0.4 }}s;">
                            <x-review-card :review="$review" />
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Reviews State -->
            <div class="mt-24 text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-helvetica font-semibold text-neutral-900 mb-2">
                        {{ __('export.reviews.display.no_reviews') }}
                    </h3>
                </div>
            </div>
        @endif
    </div>
</section>