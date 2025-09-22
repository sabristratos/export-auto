@props([
    'review',
    'class' => ''
])

<div class="container-content text-left space-y-4 {{ $class }}">
    <!-- Star Rating -->
    <div class="mb-4">
        <x-star-rating-display :rating="$review->rating" size="md" />
    </div>

    <!-- Review Content -->
    <div class="mb-6">
        <blockquote class="text-neutral-700 font-helvetica font-light leading-relaxed text-lg">
            "{{ $review->content }}"
        </blockquote>
    </div>

    <!-- Customer Information -->
    <div class="space-y-2">
        <!-- Customer name -->
        <h4 class="font-helvetica font-medium text-neutral-900 text-base">
            {{ $review->customer_name }}
        </h4>

        <!-- Location and date -->
        <div class="flex items-center space-x-3 text-sm text-neutral-500 font-helvetica font-light">
            @if($review->customer_location)
                <span class="flex items-center space-x-1">
                    <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $review->customer_location }}</span>
                </span>
                <span class="text-neutral-300">•</span>
            @endif

            <span class="flex items-center space-x-1">
                <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $review->created_at->diffForHumans() }}</span>
            </span>
        </div>

        <!-- Car model badge (if available) -->
        @if($review->car)
            <div class="mt-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-brand-50 text-brand-700 font-helvetica">
                    <svg class="w-3 h-3 mr-1.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                    {{ $review->car->make->name }} {{ $review->car->model->name ?? '' }}
                </span>
            </div>
        @endif
    </div>
</div>