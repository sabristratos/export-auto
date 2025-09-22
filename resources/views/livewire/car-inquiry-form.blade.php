<div class="w-full">
    @if($showSuccess)
        <!-- Success Message -->
        <x-keys::card class="bg-white border-0">
            <div class="text-center py-8">
                <x-keys::icon name="heroicon-o-check-circle" size="xl" class="text-success-500 mx-auto mb-4" />

                <h3 class="text-xl font-semibold text-neutral-900 mb-2">
                    {{ $successContent['title'] }}
                </h3>

                <p class="text-neutral-600 mb-6 leading-relaxed">
                    {{ $successContent['message'] }}
                </p>

                <x-keys::button variant="brand" wire:click="resetForm" size="lg">
                    {{ $successContent['button_text'] }}
                </x-keys::button>
            </div>
        </x-keys::card>
    @else
        <!-- Car Inquiry Form -->
        <x-keys::card class="bg-white border-0">
            <x-slot:header>
                <div class="text-center">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <h3 class="text-2xl font-bold text-neutral-900">
                            {{ __('Inquire About This Vehicle') }}
                        </h3>
                        @if($car->make->hasLogo())
                            <img src="{{ $car->make->getLogoUrl() }}"
                                 alt="{{ $car->make->name }} logo"
                                 class="h-8 w-auto object-contain opacity-80">
                        @endif
                    </div>
                    <p class="text-neutral-600">
                        {{ __('Get detailed information about this :make :model', [
                            'make' => $car->make->name,
                            'model' => $car->model->name
                        ]) }}
                    </p>
                    <div class="mt-2 text-lg font-semibold text-brand-600">
                        €{{ number_format($car->price) }}
                    </div>
                </div>
            </x-slot:header>

            <form wire:submit="submitInquiry" class="space-y-6">
                <!-- Name Field -->
                <x-keys::input
                    name="name"
                    wire:model="name"
                    :label="$formLabels['name']"
                    required
                    size="md"
                    :errors="$errors->get('name')"
                    icon-left="heroicon-o-user"
                    :placeholder="$placeholders['name']"
                />

                <!-- Email Field -->
                <x-keys::input
                    name="email"
                    type="email"
                    wire:model="email"
                    :label="$formLabels['email']"
                    required
                    size="md"
                    :errors="$errors->get('email')"
                    icon-left="heroicon-o-envelope"
                    :placeholder="$placeholders['email']"
                />

                <!-- Phone Field -->
                <x-keys::input
                    name="phone"
                    type="tel"
                    wire:model="phone"
                    :label="$formLabels['phone']"
                    optional
                    size="md"
                    :errors="$errors->get('phone')"
                    icon-left="heroicon-o-phone"
                    :placeholder="$placeholders['phone']"
                />

                <!-- Message Field -->
                <x-keys::field :label="$formLabels['message']" required>
                    <x-keys::textarea
                        name="message"
                        wire:model.live="message"
                        :placeholder="$placeholders['message']"
                        rows="4"
                        size="md"
                        clearable
                        required
                        :errors="$errors->get('message')"
                    />
                    <div class="flex justify-end mt-1">
                        <span class="text-sm text-neutral-500">
                            {{ $this->characterCount }} {{ __('characters remaining') }}
                        </span>
                    </div>
                </x-keys::field>


                <!-- Privacy Notice -->
                <x-keys::alert variant="info">
                    <x-slot:title>{{ __('Privacy Notice') }}</x-slot:title>
                    {{ __('Your information will be kept confidential and used only to respond to your inquiry about this vehicle.') }}
                </x-keys::alert>

                <!-- Submit Button -->
                <div class="flex justify-center pt-4">
                    <x-keys::button
                        type="submit"
                        variant="brand"
                        size="md"
                        wire:loading.attr="disabled"
                        wire:target="submitForm"
                        icon="heroicon-o-paper-airplane"
                        class="w-full"
                    >
                        {{ __('Send Inquiry') }}
                    </x-keys::button>
                </div>
            </form>
        </x-keys::card>
    @endif
</div>