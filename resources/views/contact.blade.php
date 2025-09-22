<x-layouts.app :headerVariant="'overlay'" title="{{ __('Contact Us') }} - @setting('site_name')">

    <!-- Contact Hero Banner -->
    <section class="relative bg-neutral-900 overflow-hidden">
        <!-- Background Image with Overlay -->
        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2340&auto=format&fit=crop"
             alt="{{ __('Contact page background') }}"
             class="absolute inset-0 w-full h-full object-cover opacity-20">

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-transparent"></div>

        <!-- Content Container -->
        <div class="relative z-10 container-public pt-24 pb-12 md:pt-28 md:pb-16">
            <div class="max-w-4xl">
                <!-- Header Content -->
                <div class="mb-8">
                    <!-- Page Title -->
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-3 font-helvetica">
                        {{ __('Contact Our Experts') }}
                    </h1>

                    <!-- Description -->
                    <p class="text-base md:text-lg text-white max-w-2xl font-helvetica font-light">
                        {{ __('Ready to start your car export journey? Our team of specialists is here to guide you through every step with unmatched expertise.') }}
                    </p>
                </div>

                <!-- Quick Contact Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <div class="relative group">
                        <div class="absolute -top-2 -left-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-keys::icon name="heroicon-o-phone" size="2xl" class="text-white" />
                        </div>
                        <div class="relative z-10">
                            <div class="text-xl md:text-2xl font-bold text-white mb-1 font-helvetica">
                                24/7
                            </div>
                            <div class="text-xs md:text-sm text-white/70 font-helvetica font-light">
                                {{ __('Phone Support') }}
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -top-2 -left-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-keys::icon name="heroicon-o-clock" size="2xl" class="text-white" />
                        </div>
                        <div class="relative z-10">
                            <div class="text-xl md:text-2xl font-bold text-white mb-1 font-helvetica">
                                &lt;24h
                            </div>
                            <div class="text-xs md:text-sm text-white/70 font-helvetica font-light">
                                {{ __('Response Time') }}
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -top-2 -left-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-keys::icon name="heroicon-o-globe-alt" size="2xl" class="text-white" />
                        </div>
                        <div class="relative z-10">
                            <div class="text-xl md:text-2xl font-bold text-white mb-1 font-helvetica">
                                50+
                            </div>
                            <div class="text-xs md:text-sm text-white/70 font-helvetica font-light">
                                {{ __('Countries Served') }}
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -top-2 -left-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-keys::icon name="heroicon-o-star" size="2xl" class="text-white" />
                        </div>
                        <div class="relative z-10">
                            <div class="text-xl md:text-2xl font-bold text-white mb-1 font-helvetica">
                                5.0
                            </div>
                            <div class="text-xs md:text-sm text-white/70 font-helvetica font-light">
                                {{ __('Customer Rating') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Information Section -->
    <div class="bg-white">
        <div class="container-public py-8">
            <!-- Breadcrumb -->
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-neutral-500 hover:text-neutral-900">{{ __('Home') }}</a></li>
                    <li class="text-neutral-400">/</li>
                    <li class="text-neutral-900 font-medium">{{ __('Contact') }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Contact Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-light text-neutral-900 font-helvetica mb-4">
                            {{ __('Send us a Message') }}
                        </h2>
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
                            <h3 class="text-lg font-medium text-neutral-900 font-helvetica mb-4">{{ __('Quick Contact') }}</h3>
                            <div class="space-y-4">
                                <x-keys::button
                                    variant="brand"
                                    size="lg"
                                    href="tel:{{ setting('contact_phone', '+49 123 456 7890') }}"
                                    icon="heroicon-o-phone"
                                    class="w-full"
                                >
                                    {{ __('Call Now') }}
                                </x-keys::button>

                                <x-keys::button
                                    variant="outline"
                                    size="lg"
                                    href="mailto:{{ setting('contact_email', 'info@elitecarexport.com') }}"
                                    icon="heroicon-o-envelope"
                                    class="w-full"
                                >
                                    {{ __('Send Email') }}
                                </x-keys::button>

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
                                <h4 class="font-medium text-brand-900 text-sm">{{ __('Response Guarantee') }}</h4>
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

    <!-- Why Choose Us Section -->
    <section class="bg-neutral-50 py-16 relative overflow-hidden">
        <!-- Subtle Background Elements -->
        <div class="absolute inset-0 opacity-[0.015]">
            <div class="absolute top-32 right-32 w-64 h-64 border border-neutral-300 rounded-full"></div>
            <div class="absolute bottom-32 left-32 w-48 h-48 border-2 border-neutral-200 rounded-full"></div>
        </div>

        <div class="container-public relative z-10">
            <!-- Two Column Layout -->
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:items-center">
                <!-- Left Column: Content -->
                <div class="mb-16 lg:mb-0">
                    <!-- Section Header -->
                    <div class="mb-12">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-[1px] bg-neutral-400"></div>
                            <span class="ml-4 text-sm tracking-[0.2em] uppercase font-helvetica font-light text-neutral-600">
                                {{ __('Why Choose Us') }}
                            </span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-light text-neutral-900 mb-4 font-helvetica">
                            {{ __('Elite Car Export Excellence') }}
                        </h2>
                        <p class="text-lg text-neutral-600 font-helvetica font-light leading-relaxed">
                            {{ __('We deliver excellence through expertise, reliability, and unwavering commitment to your satisfaction') }}
                        </p>
                    </div>

                    <!-- Key Benefits -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-brand-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h3 class="font-medium text-neutral-900 mb-1">{{ __('Trusted Expertise') }}</h3>
                                <p class="text-neutral-600 text-sm font-helvetica">{{ __('Years of experience with thousands of satisfied customers worldwide') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-brand-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h3 class="font-medium text-neutral-900 mb-1">{{ __('Global Network') }}</h3>
                                <p class="text-neutral-600 text-sm font-helvetica">{{ __('Shipping to 50+ countries with reliable partners') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-brand-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h3 class="font-medium text-neutral-900 mb-1">{{ __('Premium Support') }}</h3>
                                <p class="text-neutral-600 text-sm font-helvetica">{{ __('24/7 dedicated support throughout the export process') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-brand-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h3 class="font-medium text-neutral-900 mb-1">{{ __('Complete Documentation') }}</h3>
                                <p class="text-neutral-600 text-sm font-helvetica">{{ __('We handle all paperwork and legal requirements') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Contact Stats -->
                <div class="space-y-6">
                    <!-- Customer Rating -->
                    <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="text-2xl font-helvetica font-bold text-brand-600">
                            5.0
                        </div>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-lg font-light">{{ __('Customer Rating') }}</span>
                    </div>

                    <!-- Response Time -->
                    <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="text-2xl font-helvetica font-bold text-brand-600">
                            24h
                        </div>
                        <span class="text-lg font-light">{{ __('Response Time') }}</span>
                    </div>

                    <!-- Countries Served -->
                    <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="text-2xl font-helvetica font-bold text-brand-600">
                            50+
                        </div>
                        <span class="text-lg font-light">{{ __('Countries Served') }}</span>
                    </div>

                    <!-- Phone Support -->
                    <div class="flex items-center space-x-3 text-neutral-600 font-helvetica">
                        <div class="w-2 h-2 bg-brand-600 rounded-full"></div>
                        <div class="text-2xl font-helvetica font-bold text-brand-600">
                            24/7
                        </div>
                        <span class="text-lg font-light">{{ __('Phone Support') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>