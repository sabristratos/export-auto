<div class="w-full container-modal">
    @if($showSuccess)
        <!-- Success Message -->
        <x-keys::card class="bg-white shadow-2xl border-0">
            <div class="text-center py-8">
                <x-keys::icon name="heroicon-o-check-circle" size="xl" class="text-success-500 mx-auto mb-4" />

                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    {{ $successContent['title'] }}
                </h3>

                <p class="text-gray-600 mb-4">
                    {{ $successContent['message'] }}
                </p>

                <x-keys::button variant="brand" wire:click="resetForm" size="lg">
                    {{ $successContent['button_text'] }}
                </x-keys::button>
            </div>
        </x-keys::card>
    @else
        <!-- Contact Form -->
        <x-keys::card class="bg-white shadow-2xl border-0">
            <x-slot:header>
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ __('Get In Touch') }}
                    </h3>
                    <p class="text-gray-600">
                        {{ __('Ready to export your dream car? Send us a message!') }}
                    </p>
                </div>
            </x-slot:header>

            <form wire:submit="submitForm" class="space-y-6">
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

                <!-- Inquiry Type -->
                <x-keys::select
                    name="inquiry_type"
                    wire:model="inquiry_type"
                    :label="$formLabels['inquiry_type']"
                    required
                    size="md"
                    :errors="$errors->get('inquiry_type')"
                    :placeholder="$placeholders['inquiry_type']"
                >
                    @foreach($inquiryOptions as $value => $label)
                        <x-keys::select.option :value="$value" :label="$label" />
                    @endforeach
                </x-keys::select>

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
                        <span class="text-sm text-gray-500">
                            {{ $this->characterCount }} {{ __('characters remaining') }}
                        </span>
                    </div>
                </x-keys::field>

                <!-- Privacy Notice -->
                <x-keys::alert variant="info">
                    <x-slot:title>{{ __('Privacy Notice') }}</x-slot:title>
                    {{ __('Your information will be kept confidential and used only to respond to your inquiry.') }}
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
                        {{ __('Send Message') }}
                    </x-keys::button>
                </div>
            </form>
        </x-keys::card>
    @endif
</div>