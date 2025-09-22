@props([
    'reviews',
    'class' => ''
])

<div class="relative {{ $class }}" x-data="reviewCarousel(@js($reviews->toArray()))" x-init="init()">
    <!-- Carousel Container -->
    <div class="relative overflow-hidden">
        <!-- Reviews Track -->
        <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%)`">
            @foreach($reviews as $review)
                <div class="w-full flex-shrink-0 px-4">
                    <x-review-card :review="$review" />
                </div>
            @endforeach
        </div>
    </div>

    <!-- Navigation Controls -->
    <div class="flex items-center justify-between mt-12">
        <!-- Previous Button -->
        <button
            @click="previous()"
            :disabled="currentIndex === 0"
            :class="currentIndex === 0 ? 'opacity-30 cursor-not-allowed' : 'opacity-70 hover:opacity-100'"
            class="flex items-center justify-center w-12 h-12 rounded-full border border-neutral-300 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
        >
            <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Dot Indicators -->
        <div class="flex items-center space-x-3">
            @foreach($reviews as $index => $review)
                <button
                    @click="goToSlide({{ $index }})"
                    :class="currentIndex === {{ $index }} ? 'bg-brand-600 w-8' : 'bg-neutral-300 w-2'"
                    class="h-2 rounded-full transition-all duration-300 hover:bg-brand-500"
                ></button>
            @endforeach
        </div>

        <!-- Next Button -->
        <button
            @click="next()"
            :disabled="currentIndex === totalSlides - 1"
            :class="currentIndex === totalSlides - 1 ? 'opacity-30 cursor-not-allowed' : 'opacity-70 hover:opacity-100'"
            class="flex items-center justify-center w-12 h-12 rounded-full border border-neutral-300 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
        >
            <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Auto-play Indicator -->
    <div class="flex items-center justify-center mt-6">
        <div class="flex items-center space-x-2 text-xs text-neutral-400 font-helvetica font-light">
            <div :class="isPlaying ? 'animate-pulse' : ''" class="w-1.5 h-1.5 bg-brand-500 rounded-full"></div>
            <span x-text="isPlaying ? 'Auto-playing' : 'Paused'"></span>
            <button @click="toggleAutoPlay()" class="ml-2 text-brand-600 hover:text-brand-700 transition-colors">
                <span x-text="isPlaying ? 'Pause' : 'Play'"></span>
            </button>
        </div>
    </div>
</div>

<script>
function reviewCarousel(reviews) {
    return {
        reviews: reviews,
        currentIndex: 0,
        totalSlides: reviews.length,
        isPlaying: true,
        autoPlayInterval: null,
        autoPlayDelay: 5000,

        init() {
            this.startAutoPlay();
            // Pause on hover
            this.$el.addEventListener('mouseenter', () => this.pauseAutoPlay());
            this.$el.addEventListener('mouseleave', () => this.resumeAutoPlay());
        },

        next() {
            if (this.currentIndex < this.totalSlides - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0; // Loop back to start
            }
        },

        previous() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else {
                this.currentIndex = this.totalSlides - 1; // Loop to end
            }
        },

        goToSlide(index) {
            this.currentIndex = index;
        },

        startAutoPlay() {
            if (this.totalSlides <= 1) return;

            this.autoPlayInterval = setInterval(() => {
                this.next();
            }, this.autoPlayDelay);
            this.isPlaying = true;
        },

        pauseAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
            this.isPlaying = false;
        },

        resumeAutoPlay() {
            if (!this.autoPlayInterval) {
                this.startAutoPlay();
            }
        },

        toggleAutoPlay() {
            if (this.isPlaying) {
                this.pauseAutoPlay();
            } else {
                this.startAutoPlay();
            }
        }
    }
}
</script>