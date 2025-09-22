<!-- Contact Form & Information Section -->
<div id="contact" class="bg-white">
    <div class="container-public py-16">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-light text-neutral-900 font-helvetica mb-4">
                {{ __('Contact Our Experts') }}
            </h2>
            <p class="text-neutral-600 font-helvetica font-light leading-relaxed max-w-2xl mx-auto">
                {{ __('Ready to start your car export journey? Our team of specialists is here to guide you through every step with unmatched expertise.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Contact Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Form Header -->
                <div class="mb-8">
                    <h3 class="text-2xl font-light text-neutral-900 font-helvetica mb-4">
                        {{ __('Send us a Message') }}
                    </h3>
                    <p class="text-neutral-600 font-helvetica font-light leading-relaxed">
                        {{ __('Fill out the form below and our experts will get back to you within 24 hours') }}
                    </p>
                </div>

                <!-- Contact Form -->
                <livewire:contact-form />
            </div>

            <!-- Right Column: Contact Information -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <!-- Quick Contact Methods -->
                    <div class="bg-neutral-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-neutral-900 font-helvetica mb-4">{{ __('Quick Contact') }}</h4>
                        <div class="space-y-4">
                            @if(setting('contact_phone'))
                                <x-keys::button
                                    variant="brand"
                                    size="lg"
                                    href="tel:{{ setting('contact_phone') }}"
                                    icon="heroicon-o-phone"
                                    class="w-full"
                                >
                                    {{ __('Call Now') }}
                                </x-keys::button>
                            @endif

                            @if(setting('contact_email'))
                                <x-keys::button
                                    variant="outline"
                                    size="lg"
                                    href="mailto:{{ setting('contact_email') }}"
                                    icon="heroicon-o-envelope"
                                    class="w-full"
                                >
                                    {{ __('Send Email') }}
                                </x-keys::button>
                            @endif

                            @if(setting('whatsapp_number'))
                                <x-keys::button
                                    variant="success"
                                    size="lg"
                                    href="https://wa.me/{{ str_replace([' ', '-', '(', ')'], '', setting('whatsapp_number')) }}"
                                    target="_blank"
                                    icon="heroicon-o-chat-bubble-left-ellipsis"
                                    class="w-full"
                                >
                                    {{ __('WhatsApp') }}
                                </x-keys::button>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information Details -->
                    <div class="space-y-6">
                        @if(setting('contact_phone'))
                            <div class="flex items-start space-x-3">
                                <x-keys::icon name="heroicon-o-phone" class="text-brand-600 mt-1" />
                                <div>
                                    <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">{{ __('Phone') }}</div>
                                    <div class="font-medium text-neutral-900 font-helvetica">{{ setting('contact_phone') }}</div>
                                </div>
                            </div>
                        @endif

                        @if(setting('contact_email'))
                            <div class="flex items-start space-x-3">
                                <x-keys::icon name="heroicon-o-envelope" class="text-brand-600 mt-1" />
                                <div>
                                    <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">{{ __('Email') }}</div>
                                    <div class="font-medium text-neutral-900 font-helvetica">{{ setting('contact_email') }}</div>
                                </div>
                            </div>
                        @endif

                        @if(setting('contact_address'))
                            <div class="flex items-start space-x-3">
                                <x-keys::icon name="heroicon-o-map-pin" class="text-brand-600 mt-1" />
                                <div>
                                    <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">{{ __('Address') }}</div>
                                    <div class="font-medium text-neutral-900 font-helvetica whitespace-pre-line">{{ setting('contact_address') }}</div>
                                </div>
                            </div>
                        @endif

                        @if(setting('business_hours'))
                            <div class="flex items-start space-x-3">
                                <x-keys::icon name="heroicon-o-clock" class="text-brand-600 mt-1" />
                                <div>
                                    <div class="text-xs text-neutral-500 uppercase tracking-wide font-helvetica">{{ __('Business Hours') }}</div>
                                    <div class="font-medium text-neutral-900 font-helvetica whitespace-pre-line text-sm">{{ setting('business_hours') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Response Guarantee -->
                    <div class="bg-brand-50 rounded-lg p-4 border-l-4 border-brand-600">
                        <div class="flex items-center space-x-2 mb-2">
                            <x-keys::icon name="heroicon-o-clock" size="sm" class="text-brand-600" />
                            <h5 class="font-medium text-brand-900 text-sm">{{ __('Response Guarantee') }}</h5>
                        </div>
                        <p class="text-brand-800 text-sm font-helvetica">
                            {{ __('We respond to all inquiries within 24 hours') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

