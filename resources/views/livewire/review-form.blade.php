<div>
    <!-- Review Form Modal -->
    <x-keys::modal
        name="review-modal"
        :title="__('export.reviews.form.title')"
        size="lg"
    >
        @if($showSuccess)
            <!-- Success Alert -->
            <x-keys::alert variant="success" dismissible>
                {{ __('export.reviews.form.success_message') }}
            </x-keys::alert>
        @else
            <!-- Modal Description -->
            <div class="mb-6">
                <p class="text-neutral-600 font-helvetica">
                    {{ __('export.reviews.form.subtitle') }}
                </p>
            </div>

            <!-- Review Form -->
            <form wire:submit="submitReview" class="space-y-6">
                <!-- Customer Name -->
                <x-keys::input
                    name="customer_name"
                    wire:model="customer_name"
                    :label="__('export.reviews.form.customer_name')"
                    required
                    size="lg"
                    :errors="$errors->get('customer_name')"
                    icon-left="heroicon-o-user"
                />

                <!-- Customer Location -->
                <x-keys::input
                    name="customer_location"
                    wire:model="customer_location"
                    :label="__('export.reviews.form.customer_location')"
                    optional
                    size="lg"
                    icon-left="heroicon-o-map-pin"
                />

                <!-- Star Rating -->
                <div>
                    <x-keys::range
                        name="rating"
                        wire:model.live="rating"
                        :label="__('export.reviews.form.rating_label')"
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
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-neutral-700">
                            {{ __('export.reviews.form.review_content') }}
                        </span>
                        <span class="text-sm text-neutral-500">
                            {{ $this->characterCount }} {{ __('export.reviews.form.character_limit') }}
                        </span>
                    </div>

                    <x-keys::textarea
                        name="content"
                        wire:model.live="content"
                        :placeholder="__('export.reviews.form.review_content')"
                        rows="4"
                        size="lg"
                        clearable
                        required
                        :errors="$errors->get('content')"
                    />
                </div>

                <!-- Moderation Notice -->
                <x-keys::alert variant="info">
                    <x-slot:title>Review Guidelines</x-slot:title>
                    {{ __('export.reviews.form.moderation_notice') }}
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
                        {{ __('export.reviews.form.cancel_button') }}
                    </x-keys::button>

                    <x-keys::button
                        type="submit"
                        variant="brand"
                        wire:click="submitReview"
                        loading
                        icon="heroicon-o-paper-airplane"
                        size="lg"
                    >
                        {{ __('export.reviews.form.submit_button') }}
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

    <!-- Modal Auto-close JavaScript -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('close-modal-after-success', () => {
                setTimeout(() => {
                    @this.call('closeModal');
                }, 3000); // Close modal after 3 seconds
            });
        });
    </script>
</div>