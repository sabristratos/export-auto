@props([
    'review',
    'class' => ''
])

@php
    $customerInitials = collect(explode(' ', $review->customer_name))
        ->take(2)
        ->map(fn($name) => strtoupper(substr($name, 0, 1)))
        ->join('');

    $avatarColors = [
        'bg-blue-500', 'bg-purple-500', 'bg-green-500', 'bg-yellow-500',
        'bg-pink-500', 'bg-indigo-500', 'bg-red-500', 'bg-teal-500'
    ];
    $avatarColor = $avatarColors[strlen($review->customer_name) % count($avatarColors)];
@endphp

<div class="group relative bg-white/80 backdrop-blur-sm border border-neutral-200/50 rounded-2xl p-8 hover:bg-white/90 hover:shadow-lg transition-all duration-500 {{ $class }}">
    <!-- Customer Info -->
    <div class="flex items-start space-x-4 mb-6">
        <!-- Avatar -->
        <div class="flex-shrink-0 w-12 h-12 {{ $avatarColor }} rounded-full flex items-center justify-center text-white font-helvetica font-bold">
            {{ $customerInitials }}
        </div>

        <!-- Customer Details -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-helvetica font-semibold text-neutral-900 text-lg">
                        {{ $review->customer_name }}
                    </h4>
                    @if($review->customer_location)
                        <p class="text-neutral-500 text-sm font-helvetica font-light">
                            {{ $review->customer_location }}
                        </p>
                    @endif
                </div>

                <!-- Verified Badge -->
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-800 font-helvetica">
                        {{ __('export.reviews.display.verified_purchase') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Star Rating -->
    <div class="mb-4">
        <x-star-rating-display :rating="$review->rating" size="sm" />
    </div>

    <!-- Review Content -->
    <div class="mb-6">
        <p class="text-neutral-700 font-helvetica font-light leading-relaxed text-lg">
            {{ $review->content }}
        </p>
    </div>

    <!-- Review Meta -->
    <div class="flex items-center justify-between text-sm text-neutral-400 font-helvetica font-light">
        <span>
            {{ $review->created_at->diffForHumans() }}
        </span>

        @if($review->car)
            <span class="text-brand-600 font-medium">
                {{ $review->car->make->name }} {{ $review->car->model->name ?? '' }}
            </span>
        @endif
    </div>

    <!-- Subtle hover accent -->
    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-brand-50/0 to-brand-100/0 group-hover:from-brand-50/20 group-hover:to-brand-100/10 transition-all duration-500 pointer-events-none"></div>
</div>