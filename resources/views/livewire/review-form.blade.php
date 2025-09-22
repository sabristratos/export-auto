<div>
    <!-- Review Form Modal -->
    <x-keys::modal
        id="review-modal"
        title="{{ __('Write a Review') }}"
        size="lg"
        wire:model="showModal"
        wire:close="closeModal"
        wire:open="openModal"
        :closable="true"
        :close-on-escape="true"
        :close-on-backdrop="true"
    >

        @if($showSuccess)
            <!-- Success Alert -->
            <x-keys::alert variant="success" dismissible>
                {{ __('Thank you for your review! It will be published after moderation.') }}
            </x-keys::alert>
        @else
            <!-- Modal Description -->
            <div class="mb-6">
                <p class="text-neutral-600 font-helvetica">
                    {{ __('Share your experience with our car export services') }}
                </p>
            </div>

            <!-- Review Form -->
            <form wire:submit="submitReview" class="space-y-6">
                <!-- Customer Name -->
                <x-keys::input
                    name="customer_name"
                    wire:model="customer_name"
                    :label="__('Your Name')"
                    required
                    size="lg"
                    :errors="$errors->get('customer_name')"
                    icon-left="heroicon-o-user"
                />

                <!-- Customer Location -->
                <x-keys::input
                    name="customer_location"
                    wire:model="customer_location"
                    :label="__('Your Location')"
                    optional
                    size="lg"
                    icon-left="heroicon-o-map-pin"
                />

                <!-- Star Rating -->
                <div>
                    <x-keys::range
                        name="rating"
                        wire:model.live="rating"
                        :label="__('Rating')"
                        min="1"
                        max="5"
                        step="1"
                        show-values
                        size="lg"
                        required
                        :errors="$errors->get('rating')"
                        :ticks="[1, 2, 3, 4, 5]"
                        show-ticks
                    />

                    <div class="flex items-center justify-between text-sm text-neutral-500 font-helvetica mt-2">
                        <span>Poor</span>
                        <span>Excellent</span>
                    </div>
                </div>

                <!-- Review Content -->
                <x-keys::field :label="__('Review')" required>
                    <x-keys::textarea
                        name="content"
                        wire:model.live="content"
                        :placeholder="__('Share your experience with our services...')"
                        rows="4"
                        size="lg"
                        clearable
                        required
                        :errors="$errors->get('content')"
                    />
                    <div class="flex justify-end mt-1">
                        <span class="text-sm text-neutral-500">
                            {{ $this->characterCount }} {{ __('characters remaining') }}
                        </span>
                    </div>
                </x-keys::field>

                <!-- Moderation Notice -->
                <x-keys::alert variant="info">
                    <x-slot:title>Review Guidelines</x-slot:title>
                    {{ __('All reviews are moderated before publication to ensure quality and authenticity.') }}
                </x-keys::alert>
            </form>
        @endif

        <!-- Modal Footer -->
        <x-slot:footer>
            @if($showSuccess)
                <x-keys::button
                    variant="brand"
                    wire:click="closeModal"
                    size="lg"
                >
                    Close
                </x-keys::button>
            @else
                <div class="flex justify-end space-x-4">
                    <x-keys::button
                        variant="ghost"
                        wire:click="closeModal"
                        size="lg"
                    >
                        {{ __('Cancel') }}
                    </x-keys::button>

                    <x-keys::button
                        type="submit"
                        variant="brand"
                        wire:click="submitReview"
                        loading
                        icon="heroicon-o-paper-airplane"
                        size="lg"
                    >
                        {{ __('Submit Review') }}
                    </x-keys::button>
                </div>
            @endif
        </x-slot:footer>
    </x-keys::modal>

    <!-- Custom styling for star rating -->
    <style>
        [data-range] {
            --range-track-bg: #f3f4f6;
            --range-fill-bg: linear-gradient(90deg, #d97706, #f59e0b);
            --range-thumb-bg: #f59e0b;
            --range-thumb-border: #d97706;
            --range-thumb-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
    </style>

    <!-- Debug Modal Events -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Livewire !== 'undefined') {
                Livewire.on('openModal', (data) => {
                    const eventData = Array.isArray(data) ? data[0] : data;
                    if (eventData && (eventData.id === 'review-modal' || eventData.modal === 'review-modal')) {
                        const modal = document.getElementById('review-modal');
                        if (modal) {
                            modal.showModal();
                        }
                    }
                });
            }
        });
    </script>
</div>